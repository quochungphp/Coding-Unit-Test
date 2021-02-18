<?php
declare(strict_types=1);

namespace Quest\fields;


class LicenseExpiry extends DateField
{
    public function getLabel(): string
    {
        return 'Driver License Expiry';
    }
}
