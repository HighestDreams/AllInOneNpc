<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form\commands;

use HighestDreams\AllInOneNpc\form\api\SimpleForm;
use HighestDreams\AllInOneNpc\form\ManagementForm;
use HighestDreams\AllInOneNpc\npc\NpcEntity;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;

class CommandsForm extends SimpleForm
{
    public function __construct(private NpcEntity $npc)
    {
        parent::__construct();
    }

    protected function title(): string
    {
        return C::BOLD . C::DARK_PURPLE . '[§l§8Commands§r§5]';
    }

    protected function content(): string
    {
        return C::AQUA . '+ ' . C::GOLD . "§l§7Slap§r§7 commands: Execute on hit npc.\n§b+ §7§lInteract§r§7 commands: Execute on interact npc.";
    }

    protected function buttons(): array
    {
        return [
            C::BOLD . 'Slap commands',
            C::BOLD . 'Interact commands',
            C::DARK_RED . 'Back'
        ];
    }

    protected function onClickButton(Player $player, int $button): void
    {
        switch ($button) {
            case 0: /* (?) Slap commands */
                $player->sendForm(new ManageCommandsForm($this->npc, $this->npc::MODE_SLAP));
                break;
            case 1: /* (?) Interact commands */
                $player->sendForm(new ManageCommandsForm($this->npc, $this->npc::MODE_INTERACT));
                break;
            case 2: /* (?) Back */
                $player->sendForm(new ManagementForm($this->npc));
                break;
        }
    }

    protected function onClose(Player $player): void
    {
        $player->sendForm(new ManagementForm($this->npc));
    }
}