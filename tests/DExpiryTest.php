<?php
declare(strict_types=1);
require './vendor/autoload.php';


use PHPUnit\Framework\TestCase;

class DExpiryTest extends TestCase
{
    public function testLabel()
    {
        self::assertEquals('Driver License Expiry', (new \Quest\fields\LicenseExpiry())->getLabel());
    }

    public function testDateFormatIsTrue()
    {
        $field = new \Quest\fields\LicenseExpiry();
        $field->setValue('28/08/1989');
        // Implement code for test
        $date = $field->checkDateFormat($field->getValue());
        self::assertEquals('Mon 28th Aug, 1989', $date);
    }

    public function testDateFormatIsFalse()
    {
        $field = new \Quest\fields\LicenseExpiry();
        $field->setValue('01*01*01');

        // Implement code for test
        $date = $field->checkDateFormat($field->getValue());
        self::assertEquals('Mon 28th Aug, 1989', $date);
    }
}
