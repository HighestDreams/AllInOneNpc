<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\setup;

use HighestDreams\AllInOneNpc\Loader;
use HighestDreams\AllInOneNpc\npc\NpcEntity;
use HighestDreams\AllInOneNpc\traits\Accessors;
use pocketmine\player\Player;

final class SetupManager
{
    use Accessors;

    private function class(): object
    {
        return Loader::getInstance();
    }

    public function setTeleporter(Player $player, NpcEntity $npc): void
    {
        $this->class()->source['teleporter'][$player->getName()] = $npc->getId();
    }

    public function removeTeleporter(Player $player): void
    {
        unset($this->class()->source['teleporter'][$player->getName()]);
    }

    public function existTeleporter(Player $player): bool
    {
        return isset($this->class()->source['teleporter'][$player->getName()]);
    }

    public function getTeleporterId(Player $player): ?int
    {
        return $this->class()->source['teleporter'][$player->getName()];
    }
}