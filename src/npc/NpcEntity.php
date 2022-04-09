<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\npc;

use pocketmine\entity\Human;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\StringTag;

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
        /* Adding commands */
        foreach (['SlapCommands' => self::MODE_SLAP, 'InteractCommands' => self::MODE_INTERACT] as $tag => $mode) {
            if(($commandsTag = $nbt->getTag($tag)) instanceof ListTag or $commandsTag instanceof CompoundTag) {
                foreach($commandsTag as $stringTag){
                    $this->command()->add($stringTag->getValue(), $mode);
                }
            }
        }
    }

    public function saveNBT(): CompoundTag
    {
        $nbt = parent::saveNBT();
        $commandsTag = new ListTag([], NBT::TAG_String);
        foreach (['SlapCommands' => self::MODE_SLAP, 'InteractCommands' => self::MODE_INTERACT] as $tag => $mode) {
            $nbt->setTag($tag, $commandsTag);
            foreach($this->command()->getAll($mode) as $command){
                $commandsTag->push(new StringTag($command));
            }
        }
        return $nbt;
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