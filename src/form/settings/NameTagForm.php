<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form\settings;

use HighestDreams\AllInOneNpc\form\api\CustomForm;
use HighestDreams\AllInOneNpc\Loader;
use HighestDreams\AllInOneNpc\npc\NpcEntity;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;

class NameTagForm extends CustomForm
{
    public function __construct(private NpcEntity $npc)
    {
        parent::__construct();
    }

    protected function title(): string
    {
        return C::BOLD . C::DARK_PURPLE . '[Name Tag]';
    }

    protected function content(): void
    {
        $this->addLabel(C::AQUA . '+ ' . C::GOLD . 'Write a new name for npc, Use {line} to get into the next line Or Leave it empty to hide npc name.');
        $this->addInput(C::BOLD . C::WHITE . 'New Name:', 'Type here...', $this->npc->getNameTag());
        // TODO: Add some options for change color format by task
    }

    protected function onSubmit(Player $player, array $data): void
    {

        if ($data[1] == $this->npc->getNameTag()) {
            $player->sendForm(new SettingsForm($this->npc));
            return;
        }
        $this->npc->setNameTag($this->translateName($data[1]));
        $this->npc->setNameTagAlwaysVisible(!empty($data[1]));
        $player->sendMessage(Loader::PREFIX . C::GREEN . 'Name tag updated successfully.');
    }

    protected function onClose(Player $player): void
    {
        $player->sendForm(new SettingsForm($this->npc));
    }

    private function translateName(string $text): string
    {
        return str_replace(['{LINE}', '{line}', '{Line}'], ["\n", "\n", "\n"], $text);
    }
}