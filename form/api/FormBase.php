<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form\api;

use pocketmine\player\Player;

trait FormBase
{
    /** @var array */
    private array $data = array();

    private function init(array $content = null)
    {
        $this->data['type'] = self::TYPE;
        $this->data['title'] = $this->title();
        $this->data['content'] = $content ?? $this->content();
    }

    private function addButtons(): void
    {
        foreach ($this->buttons() as $text => $image) {
            $button = array();
            if (is_string($text)) {
                $button['text'] = $text;
                if (!empty($image)) {
                    $button['image']['type'] = preg_match('/htt.+:\/\//i', $image) ? 'url' : 'path';
                    $button['image']['data'] = $image;
                }
            } else {
                $button['text'] = $image;
            }
            $this->data['buttons'][] = $button;
        }
    }

    public final function jsonSerialize(): array
    {
        return $this->data;
    }

    public final function handleResponse(Player $player, mixed $data): void
    {
        switch (gettype($data)) {
            case 'boolean':
                $data ? $this->onClickFirstButton($player) : $this->onClickSecondButton($player);
                return;
            case 'integer':
                $this->onClickButton($player, (int)$data);
                return;
            case 'NULL':
                $this->onClose($player);
                return;
            case 'array':
                $this->onSubmit($player, (array)$data);
                return;
        }
    }
}