<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\command;

use HighestDreams\AllInOneNpc\Loader;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;

class NpcCommand extends Command
{
    public function __construct()
    {
        parent::__construct('npc', 'All in one Npc', null, []);
        $this->setPermission('npc.command');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        /* (?) Test player permissions */
        if (!$this->testPermission($sender) or !$sender instanceof Player) {
            $sender->sendMessage(Loader::PREFIX . C::RED . 'You cannot use this command.');
            return;
        }
        /* (?) Checking arguments of command */
        if (isset($args[0])) {
            switch ($args[0]) {
                case 'spawn':
                case 'summon':
                case 'create':
                case 'make':
                    Loader::getInstance()->npcManager()->spawnNpc($sender->getLocation(), $sender->getSkin()); // TODO: Use steve skin instead player skin
                    $sender->sendMessage(Loader::PREFIX . '§7Npc spawned §asuccessfully§7, Use §e/npc edit§7 to §aenable§7/§cdisable§7 editor mode for yourself.');
                    break;
                case 'edit':
                case 'setup':
                case 'setting':
                case 'settings':
                case 'manage':
                    $setup = Loader::getInstance()->setupManager();
                    if ($setup->exist($sender->getName(), 'editor')) {
                        $setup->remove($sender->getName(), 'editor');
                        $sender->sendMessage(Loader::PREFIX . '§7You\'ve been §cdisabled§7 editor mode for yourself.');
                        return;
                    }
                    $setup->add($sender->getName(), 'editor');
                    $sender->sendMessage(Loader::PREFIX . '§7You\'ve been §aenabled§7 editor mode for yourself.');
                    break;
                default:
                    $sender->sendMessage(Loader::PREFIX . C::RED . 'Usage: /npc <spawn|edit>');
                    break;
            }
            return;
        }
        $sender->sendMessage(Loader::PREFIX . C::RED . 'Usage: /npc <spawn|edit>');
    }
}