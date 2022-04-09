<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form\commands;

use HighestDreams\AllInOneNpc\form\api\SimpleForm;
use HighestDreams\AllInOneNpc\npc\NpcEntity;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;

class EditCommandForm extends SimpleForm
{
    public function __construct(private NpcEntity $npc, private string $mode, private string $command)
    {
        parent::__construct();
    }

    protected function title(): string
    {
        return C::BOLD . C::DARK_PURPLE . '[§l§8Command Editor§r§5]';
    }

    protected function content(): string
    {
        return C::AQUA . '+ ' . C::GOLD . 'Command: ' . C::GREEN . $this->command;
    }

    protected function buttons(): array
    {
        return [C::DARK_RED . 'Delete'];
        // TODO: Add edit option to edit commands
    }

    protected function onClickButton(Player $player, int $button): void
    {
        switch ($button) {
            case 0:
                $this->npc->command()->remove($this->command, $this->mode);
                $player->sendForm(new CommandsListForm($this->npc, $this->mode));
                break;
        }
    }

    protected function onClose(Player $player): void
    {
        $player->sendForm(new CommandsListForm($this->npc, $this->mode));
    }
}