<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form\commands;

use HighestDreams\AllInOneNpc\form\api\SimpleForm;
use HighestDreams\AllInOneNpc\npc\NpcEntity;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;

class ManageCommandsForm extends SimpleForm
{
    public function __construct(private NpcEntity $npc, private string $mode)
    {
        parent::__construct();
    }

    protected function title(): string
    {
        return C::BOLD . C::DARK_PURPLE . '[§l§8Manage Command§r§5]';
    }

    protected function content(): string
    {
        return C::AQUA . '+ ' . C::GOLD . "Select a button.";
    }

    protected function buttons(): array
    {
        return [
            C::BOLD . 'Commands List',
            C::BOLD . 'Add Command',
            C::DARK_RED . 'Back'
        ];
    }

    protected function onClickButton(Player $player, int $button): void
    {
        switch ($button) {
            case 0: /* (?) Commands list */
                $player->sendForm(new CommandsListForm($this->npc, $this->mode));
                break;
            case 1: /* (?) Add Command */
                $player->sendForm(new AddCommandForm($this->npc, $this->mode));
                break;
            case 2: /* (?) Back */
                $player->sendForm(new CommandsForm($this->npc));
                break;
        }
    }

    protected function onClose(Player $player): void
    {
        $player->sendForm(new CommandsForm($this->npc));
    }
}