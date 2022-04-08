<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\setup;

use HighestDreams\AllInOneNpc\Loader;
use HighestDreams\AllInOneNpc\traits\Accessors;

final class SetupManager
{
    use Accessors;

    private function class(): object
    {
        return Loader::getInstance();
    }
}