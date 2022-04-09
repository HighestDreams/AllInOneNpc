<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form\commands;

use HighestDreams\AllInOneNpc\form\api\CustomForm;
use HighestDreams\AllInOneNpc\npc\NpcEntity;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;

class AddCommandForm extends CustomForm
{
    public function __construct(private NpcEntity $npc, private string $mode)
    {
        parent::__construct();
    }

    protected function title(): string
    {
        return C::BOLD . C::DARK_PURPLE . '[§l§8Add command§r§5]';
    }

    protected function content(): void
    {
        $this->addLabel("§b+ §6Type your command in input, You can even use tags:\n{player} to get player's name\n{rcap} in the start if your command to run it as player.");
        $this->addInput(C::BOLD . C::WHITE . 'New Command:', 'Type command here...');
    }

    protected function onSubmit(Player $player, array $data): void
    {
        if (!empty($data[1])) {
            $this->npc->command()->add($data[1], $this->mode);
            $player->sendForm(new CommandsListForm($this->npc, $this->mode));
            return;
        }
        $player->sendForm(new ManageCommandsForm($this->npc, $this->mode));
    }

    protected function onClose(Player $player): void
    {
        $player->sendForm(new ManageCommandsForm($this->npc, $this->mode));
    }
}