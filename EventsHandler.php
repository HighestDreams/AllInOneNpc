<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc;

use HighestDreams\AllInOneNpc\form\ManagementForm;
use HighestDreams\AllInOneNpc\npc\NpcEntity;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\player\Player;

class EventsHandler implements Listener
{
    public function onHitNpc(EntityDamageEvent $event)
    {
        $npc = $event->getEntity();
        if ($npc instanceof NpcEntity) {
            $event->cancel();
            /* (?) Check if a player hit the npc */
            if ($event instanceof EntityDamageByEntityEvent) {
                $player = $event->getDamager();
                if ($player instanceof Player) {
                    /* (?) If player is in editor mode, it must open Management form */
                    if (Loader::getInstance()->setupManager()->exist($player->getName(), 'editor')) {
                        $player->sendForm(new ManagementForm($npc));
                        return;
                    }
                    /* Execute the commands of Npc */
                }
            }
        }
    }
}