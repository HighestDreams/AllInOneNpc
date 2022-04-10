<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc;

use HighestDreams\AllInOneNpc\form\ManagementForm;
use HighestDreams\AllInOneNpc\npc\NpcEntity;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerEntityInteractEvent;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

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
                    $npc->command()->execute($npc::MODE_SLAP, $player);
                }
            }
        }
    }

    public function onInteractNpc(PlayerEntityInteractEvent $event)
    {
        $player = $event->getPlayer();
        $npc = $event->getEntity();
        if ($npc instanceof NpcEntity) {
            /* (?) If player is in editor mode, it must open Management form */
            if (Loader::getInstance()->setupManager()->exist($player->getName(), 'editor')) {
                $player->sendForm(new ManagementForm($npc));
                return;
            }
            /* Execute the commands of Npc */
            $npc->command()->execute($npc::MODE_INTERACT, $player);
        }
    }

    public function onSendingHere(PlayerChatEvent $event)
    {
        $player = $event->getPlayer();
        $setup = Loader::getInstance()->setupManager();
        /* If player is in teleporters list */
        if ($setup->existTeleporter($player)) {
            /* Reset the colors of message */
            $message = preg_replace('/(§.)/i', '', strtolower($event->getMessage()));
            if ($message === 'here') {
                $event->cancel();
                $npc = $player->getWorld()->getEntity($setup->getTeleporterId($player));
                /* If npc is still exist (Not deleted) */
                if ($npc instanceof NpcEntity) {
                    $npc->teleport($player->getLocation());
                    $player->sendMessage(Loader::PREFIX . '§aNpc teleported successfully.');
                    return;
                }
                $player->sendMessage(Loader::PREFIX . '§cNpc is not exist in your world!');
            }
        }
    }
}