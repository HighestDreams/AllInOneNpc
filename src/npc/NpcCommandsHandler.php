<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\npc;

use HighestDreams\AllInOneNpc\traits\Accessors;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\lang\Language;
use pocketmine\player\Player;
use pocketmine\Server;

final class NpcCommandsHandler
{
    use Accessors;

    public function __construct(private NpcEntity $npc) {}

   private function class(): object
    {
        return $this->npc;
    }

    public function execute(string $mode, Player $player): void
    {
        foreach ($this->npc->command()->getAll($mode) as $command) {
            $command = str_replace(['{player}', '{rcap}'], [$player->getName(), 'rcap'], $command);
            Server::getInstance()->dispatchCommand(new ConsoleCommandSender(Server::getInstance(), new Language(Language::FALLBACK_LANGUAGE)), $command);
        }
    }
}