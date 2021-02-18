<?php
declare(strict_types=1);

namespace Quest\fields;

abstract class DateField extends AbstractField
{

  public function setValue(string $value): void
  {
    parent::setValue(trim($value));
  }

  // Implement checking date format
  public function checkDateFormat($field) : string
  {
    try {
      $date = trim($field);
      $dateType = [
        "/^(0?[1-9]|[1-2][0-9]|3[0-1])-(0?[1-9]|1[0-2])-[0-9]{2,4}$/",
        "/^(0?[1-9]|[1-2][0-9]|3[0-1])\.(0?[1-9]|1[0-2])\.[0-9]{2,4}$/",
        "/^(0?[1-9]|[1-2][0-9]|3[0-1])\/(0?[1-9]|1[0-2])\/[0-9]{2,4}$/",
        "/^[0-9]{2,4}-(0?[1-9]|1[0-2])-((0?[1-9])|([1-2][0-9])|(3[0-1]))$/",
        "/^[0-9]{2,4}\.(0?[1-9]|1[0-2])\.((0?[1-9])|([1-2][0-9])|(3[0-1]))$/",
        "/^[0-9]{2,4}\/(0?[1-9]|1[0-2])\/((0?[1-9])|([1-2][0-9])|(3[0-1]))$/"
      ];

      $dateFormat = 'D jS M, Y ';
      $newDate = "";
      $flash = false;

      foreach ($dateType as $key => $value) {
        if (preg_match($value, $date)) {
          $reDate = preg_split("/[\s\/\-\.]+/", $date);
          $reDate = implode("-", $reDate);

          $newDate = date($dateFormat, strtotime($reDate));
          $flash = true;
          break;
        }
      }

      if (!$flash) {
        $mess = ' Input current date: ' . $date . ' was wrong format.';
        throw new \Exception($mess);
      }

      return trim($newDate);

    } catch (\Exception $e) {
      return 'Error message: ' . $e->getMessage();
      exit();
    }
  }
}
