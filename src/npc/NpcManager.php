<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\npc;

use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\entity\Human;
use pocketmine\entity\Location;
use pocketmine\entity\Skin;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\World;

final class NpcManager
{
    public final function spawnNpc(Location $location, Skin $skin, CompoundTag $nbt = null): NpcEntity
    {
        $npc = new NpcEntity($location, $skin, $nbt);
        $npc->setNameTag(NpcEntity::DEFAULT_NAME . " #{$npc->getId()}");
        $npc->spawnToAll();
        return $npc;
    }

    public final function registerNpc(): void
    {
        EntityFactory::getInstance()->register(NpcEntity::class, static function (World $world, CompoundTag $nbt): NpcEntity {
            return new NpcEntity(EntityDataHelper::parseLocation($nbt, $world), Human::parseSkinNBT($nbt), $nbt);
        }, ['Human']);
    }
}