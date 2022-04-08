<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form\settings;

use HighestDreams\AllInOneNpc\form\api\SimpleForm;
use HighestDreams\AllInOneNpc\form\ManagementForm;
use HighestDreams\AllInOneNpc\npc\NpcEntity;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;

class SettingsForm extends SimpleForm
{
    public function __construct(private NpcEntity $npc)
    {
        parent::__construct();
    }

    protected function title(): string
    {
        return C::BOLD . C::DARK_PURPLE . '[Settings]';
    }

    protected function content(): string
    {
        return C::AQUA . '+ ' . C::GOLD . 'Select a button.';
    }

    protected function buttons(): array
    {
        return [
            C::BOLD . 'Name',
            C::BOLD . 'Skin',
            C::BOLD . 'Emote',
            C::DARK_RED . 'Back'
        ];
    }

    protected function onClickButton(Player $player, int $button): void
    {
        switch ($button)
        {
            case 0: /* (?) Name */
                $player->sendForm(new NameTagForm($this->npc));
                break;
            case 1: /* (?) Skin */
                // Skin
                break;
            case 2: /* (?) Emote */
                // Emote
                break;
            case 3: /* (?) Back */
                $player->sendForm(new ManagementForm($this->npc));
                break;
        }
    }
}