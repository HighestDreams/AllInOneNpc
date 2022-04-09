<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc;

use HighestDreams\AllInOneNpc\command\NpcCommand;
use HighestDreams\AllInOneNpc\command\RcapCommand;
use HighestDreams\AllInOneNpc\npc\NpcManager;
use HighestDreams\AllInOneNpc\setup\SetupManager;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase
{
    private static self $Instance;

    public const PREFIX = '§l§cNpc §r§3> §r';

    public array $source = array(
        'editor' => array(),
        'teleporter' => array()
    );

    protected function onEnable(): void
    {
        self::$Instance = $this;
        /* (?) Registering commands */
        $this->getServer()->getCommandMap()->register('npc', new NpcCommand());
        $this->getServer()->getCommandMap()->register('rcap', new RcapCommand());
        /* (?) Registering npc */
        $this->npcManager()->registerNpc();
        /* (?) Registering events */
        $this->getServer()->getPluginManager()->registerEvents(new EventsHandler(), $this);
    }

    public function npcManager(): NpcManager
    {
        return new NpcManager();
    }

    public function setupManager(): SetupManager
    {
        return new SetupManager();
    }

    public static function getInstance(): self
    {
        return self::$Instance;
    }
}
