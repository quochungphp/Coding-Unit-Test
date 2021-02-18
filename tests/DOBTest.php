<?php
declare(strict_types=1);
require './vendor/autoload.php';


use PHPUnit\Framework\TestCase;

class DOBTest extends TestCase
{
    public function testLabel()
    {
        self::assertEquals('Date Of Birth', (new \Quest\fields\DateOfBirth())->getLabel());
    }

    public function testDateFormatIsTrue()
    {
        $field = new \Quest\fields\DateOfBirth();
        $field->setValue('28/08/1989');
        // Implement code for test
        $date = $field->checkDateFormat($field->getValue());
        self::assertEquals('Mon 28th Aug, 1989', $date);
    }

    public function testDateFormatIsFalse()
    {
        $field = new \Quest\fields\DateOfBirth();
        $field->setValue('09*09*09');

        // Implement code for test
        $date = $field->checkDateFormat($field->getValue());
        self::assertEquals('Mon 28th Aug, 1989', $date);
    }
}
