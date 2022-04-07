<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\traits;

trait Accessors
{
    abstract function class(): object;

    public final function add(string $value, string $index): void
    {
        $this->class()->source[$index][] = $value;
    }

    public final function remove(string $value, string $index): void
    {
        unset($this->class()->source[$index][array_search($value, $this->class()->source[$index])]);
    }

    public final function exist(string $value, string $index): bool
    {
        return in_array($value, $this->class()->source[$index]);
    }
}