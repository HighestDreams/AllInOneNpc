<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form\settings;

use HighestDreams\AllInOneNpc\form\api\CustomForm;
use HighestDreams\AllInOneNpc\Loader;
use HighestDreams\AllInOneNpc\npc\NpcEntity;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as C;

class SkinForm extends CustomForm
{
    private array $online_players = array('Not selected');

    public function __construct(private NpcEntity $npc)
    {
        /* (?) Inserting players name to the array */
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            $this->online_players[] = $player->getName();
        }
        parent::__construct();
    }

    protected function title(): string
    {
        return C::BOLD . C::DARK_PURPLE . '[Skin]';
    }

    protected function content(): void
    {
        $this->addLabel(C::AQUA . '+ ' . C::GOLD . 'You can change npc skin to online players skin by choosing player from dropdown below.');
        $this->addDropdown(C::BOLD . C::WHITE . 'Choose a player', $this->online_players);
        // TODO: Add new option to change skin from data folder
    }

    protected function onSubmit(Player $player, array $data): void
    {
        /* (?) Check if its not first element of array (Not selected) */
        if ($data[1] > 0) {
            /* (?) Check if target is still online */
            $target = Server::getInstance()->getPlayerExact($this->online_players[$data[1]]);
            if ($target instanceof Player) {
                $this->npc->setSkin($target->getSkin());
                $this->npc->sendSkin();
                $player->sendMessage(Loader::PREFIX . C::GREEN . 'Skin updated successfully.');
                return;
            }
            $player->sendMessage(Loader::PREFIX . C::RED . "Player {$target->getName()} is not online!");
            return;
        }
        $player->sendForm(new SettingsForm($this->npc));
    }

    protected function onClose(Player $player): void
    {
        $player->sendForm(new SettingsForm($this->npc));
    }
}