<?php
declare(strict_types=1);

namespace Quest\fields;


abstract class TextField extends AbstractField
{
    public function setValue(string $value): void
    {
        parent::setValue(trim($value));
    }
}
