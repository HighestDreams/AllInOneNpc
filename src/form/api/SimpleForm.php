<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form\api;

use pocketmine\form\Form;
use pocketmine\player\Player;

abstract class SimpleForm implements Form
{
    use FormBase;

    private const TYPE = 'form';

    public  function __construct() {
        $this->init();
        $this->addButtons();
    }

    abstract protected function title(): string;

    abstract protected function content(): string;

    abstract protected function buttons(): array;

    protected function onClickButton(Player $player, int $button): void {}

    protected function onClose(Player $player): void {}
}
