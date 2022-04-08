<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form\api;

use pocketmine\form\Form;
use pocketmine\player\Player;

abstract class CustomForm implements Form
{
    use FormBase, FormEntries;

    private const TYPE = 'custom_form';

    /** @var array */
    private array $content = array();

    public function __construct() {
        $this->init($this->content);
        $this->content();
    }

    abstract protected function title(): string;

    abstract protected function content(): void;

    protected function onSubmit(Player $player, array $data): void {}

    protected function onClose(Player $player): void {}
}
