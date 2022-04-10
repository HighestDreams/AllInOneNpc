<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form;

use HighestDreams\AllInOneNpc\form\api\SimpleForm;
use HighestDreams\AllInOneNpc\form\commands\CommandsForm;
use HighestDreams\AllInOneNpc\form\settings\SettingsForm;
use HighestDreams\AllInOneNpc\Loader;
use HighestDreams\AllInOneNpc\npc\NpcEntity;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;

class ManagementForm extends SimpleForm
{
    public function __construct(private NpcEntity $npc)
    {
        parent::__construct();
    }

    protected function title(): string
    {
        return C::BOLD . C::DARK_PURPLE . '[§l§8Npc Menu§r§5]';
    }

    protected function content(): string
    {
        return C::AQUA . '+ ' . C::GOLD . 'Select a button.';
    }

    protected function buttons(): array
    {
        return [
            C::BOLD . 'Settings',
            C::BOLD . 'Commands',
            C::DARK_AQUA . 'Teleport',
            C::DARK_RED . 'Delete'
        ];
    }

    protected function onClickButton(Player $player, int $button): void
    {
        switch ($button)
        {
            case 0: /* (?) Settings */
                $player->sendForm(new SettingsForm($this->npc));
                break;
            case 1: /* (?) Commands */
                $player->sendForm(new CommandsForm($this->npc));
                break;
            case 2: /* (?) Teleport */
                $setup = Loader::getInstance()->setupManager();
                if ($setup->existTeleporter($player)) {
                    if ($setup->getTeleporterId($player) == $this->npc->getId()) {
                        $player->sendMessage(Loader::PREFIX . '§7You are currently teleporting this NPC! Go to the place you want and send §chere§7 in chat to teleport NPC.');
                        return;
                    }
                    $player->sendMessage(Loader::PREFIX . '§7The teleportation operation for §bNPC #' . $setup->getTeleporterId($player) . '§7 has been §ccanceled§7, you are now teleporting §bNPC #' . $this->npc->getId() . '§7, Go to the place you want and send §chere§7 in chat to teleport NPC.');
                    $setup->setTeleporter($player, $this->npc);
                    return;
                }
                $setup->setTeleporter($player, $this->npc);
                $player->sendMessage(Loader::PREFIX . '§7You are now teleporting §bNPC #' . $this->npc->getId() . '§7, Go to the place you want and send §chere§7 in chat to teleport NPC.');
                break;
            case 3: /* (?) Delete */
                $player->sendForm(new DeletionForm($this->npc));
                break;
        }
    }
}