<?php
declare(strict_types=1);

namespace Quest\fields;


class DateOfBirth extends DateField
{
    public function getLabel(): string
    {
        return 'Date Of Birth';
    }
}