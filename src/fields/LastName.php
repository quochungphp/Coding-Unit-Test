<?php
declare(strict_types=1);

namespace Quest\fields;

class LastName extends TextField
{
    public function getLabel(): string
    {
        return 'Last Name';
    }
}