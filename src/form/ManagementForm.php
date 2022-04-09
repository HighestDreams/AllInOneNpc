<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form;

use HighestDreams\AllInOneNpc\form\api\SimpleForm;
use HighestDreams\AllInOneNpc\form\commands\CommandsForm;
use HighestDreams\AllInOneNpc\form\settings\SettingsForm;
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
                //
            case 3: /* (?) Delete */
                $player->sendForm(new DeletionForm($this->npc));
                break;
        }
    }
}