<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\command;

use HighestDreams\AllInOneNpc\Loader;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as C;

class RcapCommand extends Command
{
    public function __construct()
    {
        parent::__construct('rcap', 'Run command as player', null, []);
        $this->setPermission('rcap.command');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        /* (?) Test player permissions */
        if (!$this->testPermission($sender)) {
            $sender->sendMessage(Loader::PREFIX . C::RED . 'You cannot use this command.');
            return;
        }
        /* (?) Checking arguments of command */
        if (count($args) >= 2) {
            $target = Server::getInstance()->getPlayerExact(array_shift($args));
            if ($target instanceof Player) {
                Server::getInstance()->dispatchCommand($target, trim(implode(" ", $args)));
                return;
            }
            $sender->sendMessage(Loader::PREFIX . C::RED .  'Player not found.');
            return;
        }
        $sender->sendMessage(Loader::PREFIX . "Usage: /rca <player-name> <command-for-execute>");
    }
}