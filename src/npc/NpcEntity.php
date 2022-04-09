<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\npc;

use pocketmine\entity\Human;
use pocketmine\nbt\tag\CompoundTag;

class NpcEntity extends Human
{
    public const DEFAULT_NAME = 'Npc';

    public const MODE_SLAP = 'slap';

    public const MODE_INTERACT = 'interact';

    public array $source = array(
        self::MODE_SLAP => array(),
        self::MODE_INTERACT => array()
    );

    public function initEntity(CompoundTag $nbt): void
    {
        parent::initEntity($nbt);
        $this->setNameTagAlwaysVisible();
    }

    public function canBeMovedByCurrents(): bool
    {
        return false;
    }

    public function command(): NpcCommandsHandler
    {
        return new NpcCommandsHandler($this);
    }
}