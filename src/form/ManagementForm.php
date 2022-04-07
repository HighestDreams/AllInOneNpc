<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form;

use HighestDreams\AllInOneNpc\form\api\SimpleForm;
use HighestDreams\AllInOneNpc\form\settings\SettingsForm;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;

class ManagementForm extends SimpleForm
{
    protected function title(): string
    {
        return C::BOLD . C::DARK_PURPLE . '[All In One NPC]';
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
                $player->sendForm(new SettingsForm());
                break;
            case 1:
                // Commands
                break;
            case 2:
                // Teleport
                break;
            case 4:
                // Delete
                break;
        }
    }
}