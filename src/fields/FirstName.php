<?php
declare(strict_types=1);

namespace Quest\fields;

class FirstName extends TextField
{
    public function getLabel(): string
    {
        return 'First Name';
    }
}