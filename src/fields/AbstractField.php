<?php
declare(strict_types=1);

namespace Quest\fields;

use Quest\contracts\Input;

abstract class AbstractField implements Input
{
    protected string $value;

    public function getInput(): void
    {
        echo $this->getLabel().": ";
        $this->setValue(\Seld\CliPrompt\CliPrompt::prompt());
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
    public function getValue(): string
    {
        return $this->value;
    }
}