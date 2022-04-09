<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form\commands;

use HighestDreams\AllInOneNpc\form\api\SimpleForm;
use HighestDreams\AllInOneNpc\npc\NpcEntity;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;

class CommandsListForm extends SimpleForm
{
    private array $commands;

    public function __construct(private NpcEntity $npc, private string $mode)
    {
        $this->commands = array_values($this->npc->command()->getAll($this->mode));
        parent::__construct();
    }

    protected function title(): string
    {
        return C::BOLD . C::DARK_PURPLE . '[§l§8Commands List§r§5]';
    }

    protected function content(): string
    {
        return C::AQUA . '+ ' . C::GOLD . 'Select a command to manage.';
    }

    protected function buttons(): array
    {
        return array_merge(preg_filter('/(.+)/i', '§' . rand(1, 5) . '$0', $this->commands), [C::DARK_RED . 'Back']);
    }

    protected function onClickButton(Player $player, int $button): void
    {
        /* Back button */
        if ($button == count($this->commands)) {
            $player->sendForm(new ManageCommandsForm($this->npc, $this->mode));
            return;
        }
        $player->sendForm(new EditCommandForm($this->npc, $this->mode, $this->commands[$button]));
    }

    protected function onClose(Player $player): void
    {
        $player->sendForm(new ManageCommandsForm($this->npc, $this->mode));
    }
}