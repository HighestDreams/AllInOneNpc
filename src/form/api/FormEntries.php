<?php

declare(strict_types=1);

namespace HighestDreams\AllInOneNpc\form\api;

trait FormEntries
{
    public final function addLabel(string $text): void
    {
        $this->data['content'][] = ['type' => 'label', 'text' => $text];
    }

    public final function addToggle(string $text, bool $default): void
    {
        $this->data['content'][] = ['type' => 'toggle', 'text' => $text, 'default' => $default];
    }

    public final function addSlider(string $text, int $min, int $max, int $step = null, int $defaultIndex = null): void
    {
        $this->data['content'][] = ['type' => 'slider', 'text' => $text, 'min' => $min, 'max' => $max, 'step' => $step, 'default' => $defaultIndex];
    }

    public final function addStepSlider(string $text, array $steps, int $defaultIndex = null): void
    {
        $this->data['content'][] = ['type' => 'step_slider', 'text' => $text, 'steps' => $steps, 'default' => $defaultIndex];
    }

    public final function addDropdown(string $text, array $options, int $defaultOption = null): void
    {
        $this->data['content'][] = ['type' => 'dropdown', 'text' => $text, 'options' => $options, 'default' => $defaultOption];
    }

    public final function addInput(string $text, string $placeholder = '', string $defaultText = null): void
    {
        $this->data['content'][] = ['type' => 'input', 'text' => $text, 'placeholder' => $placeholder, 'default' => $defaultText];
    }
}