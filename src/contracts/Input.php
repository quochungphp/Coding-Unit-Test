<?php
declare(strict_types=1);

namespace Quest\contracts;

interface Input
{
    public function getLabel(): string;
    public function getInput(): void;
    public function setValue(string $value): void;
    public function getValue(): string;
}