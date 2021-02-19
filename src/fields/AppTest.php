<?php
declare(strict_types=1);
require './vendor/autoload.php';


use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{

    public function testAppIsTrue() {
      $app = new \Quest\App();
      $ques = $app->getIntanceClass();
      $dataMocks = [
        "Le",
        "Quoc Hung",
        "28/08/1989",
        "20-02-2025"
      ];

      foreach ($ques as $key => $field) {
        $instance = new $field;
        $instance->setValue($dataMocks[$key]);
        if ($instance instanceof  Quest\fields\DateOfBirth) {
          $date = $instance->checkDateFormat($instance->getValue());
          self::assertEquals('Mon 28th Aug, 1989', $date);
        } else if ($instance instanceof  Quest\fields\LicenseExpiry) {
          $date = $instance->checkDateFormat($instance->getValue());
          self::assertEquals('Thu 20th Feb, 2025', $date);
        }
      }
    }

    public function testAppIsWrong() {
      $app = new \Quest\App();
      $ques = $app->getIntanceClass();
      $dataMocks = [
        "Le",
        "Quoc Hung",
        "28*08*1989",
        "20*02*2025"
      ];

      foreach ($ques as $key => $field) {
        $instance = new $field;
        $instance->setValue($dataMocks[$key]);
        if ($instance instanceof  Quest\fields\DateOfBirth) {
          $date = $instance->checkDateFormat($instance->getValue());
          self::assertEquals('Mon 28th Aug, 1989', $date);
        } else if ($instance instanceof  Quest\fields\LicenseExpiry) {
          $date = $instance->checkDateFormat($instance->getValue());
          self::assertEquals('Thu 20th Feb, 2025', $date);
        }
      }
    }
}