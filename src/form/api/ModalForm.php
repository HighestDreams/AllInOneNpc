<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form\api;

use pocketmine\form\Form;
use pocketmine\player\Player;

abstract class ModalForm implements Form
{
    use FormBase;

    private const TYPE = 'modal';

    public  function __construct()
    {
        $this->init();
        $this->data['button1'] = $this->firstButton();
        $this->data['button2'] = $this->secondButton();
    }

    abstract protected function title(): string;

    abstract protected function content(): string;

    abstract protected function firstButton(): string;

    abstract protected function secondButton(): string;

    protected function onClickFirstButton(Player $player): void {}

    protected function onClickSecondButton(Player $player): void {}
}
