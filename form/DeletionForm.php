<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form;

use HighestDreams\AllInOneNpc\form\api\ModalForm;
use HighestDreams\AllInOneNpc\Loader;
use HighestDreams\AllInOneNpc\npc\NpcEntity;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;

class DeletionForm extends ModalForm
{
    public function __construct(private NpcEntity $npc)
    {
        parent::__construct();
    }

    protected function title(): string
    {
        return C::BOLD . C::DARK_PURPLE . 'Deleting Npc #' . $this->npc->getId();
    }

    protected function content(): string
    {
        return C::AQUA . '+ ' . C::GOLD . 'Are you sure you want to delete this npc? If you make a mistake, you will not be able to recover your NPC.';
    }

    protected function firstButton(): string
    {
        return C::DARK_GREEN . 'Yes, I\'m sure';
    }

    protected function secondButton(): string
    {
        return C::DARK_RED . 'No, Never mind';
    }

    protected function onClickFirstButton(Player $player): void
    {
        if ($this->npc->isAlive()) {
            $this->npc->flagForDespawn();
            $player->sendMessage(Loader::PREFIX . C::GREEN . 'Npc deleted successfully.');
            return;
        }
        $player->sendMessage(Loader::PREFIX . C::RED . 'Npc deletion failed, Npc is not exist.');
    }
}