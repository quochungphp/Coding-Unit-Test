<?php

namespace Quest;

use DateTime;
use Quest\contracts\Input;
use Quest\fields\DateOfBirth;
use Quest\fields\FirstName;
use Quest\fields\LastName;
use Quest\fields\LicenseExpiry;

date_default_timezone_set('UTC');
class App {

    private const QUESTIONS = [
        FirstName::class,
        LastName::class,
        DateOfBirth::class,
        LicenseExpiry::class,
    ];

    /**
     * @var Input[]
     */
    private array $fields = [];

    public function run()
    {
        $this->createFields();
        $this->askQuestions();
        $this->showResponses();
    }

    private function createFields(): void
    {
        foreach(self::QUESTIONS as $questionClass) {
            $this->fields[] = new $questionClass();
        }
    }

    private function askQuestions(): void
    {
        foreach($this->fields as $field) {
            $field->getInput();
        }
    }

    private function showResponses(): void
    {
        echo "\nResponses:\n";
        foreach($this->fields as $field) {

            if ($field instanceof DateOfBirth) {
                $this->checkDateFormat($field);
            } else {
                echo '  - ' . $field->getLabel() . ': ' . $field->getValue() . "\n";
            }
        }
        echo "\nThank You!\n\n";
    }

    private function checkDateFormat($field) : void {
        $date = trim($field->getValue());
        $dateType = [
            "/^(0?[1-9]|[1-2][0-9]|3[0-1])(-|\/|.)(0?[1-9]|1[0-2])(-|\/|.)[0-9]{4}$/", // 28-08-1989 (-,.,/)
            "/^(0?[1-9]|[1-2][0-9]|3[0-1])(-|\/|.)(0?[1-9]|1[0-2])(-|\/|.)[0-9]{2}$/", // 28-08-89 (-,.,/)
            "/^[0-9]{4}(-|\/|.)(0?[1-9]|1[0-2])(-|\/|.)((0?[1-9])|([1-2][0-9])|(3[0-1]))$/", // 1989-08-28 | 1989-8-8
            "/^[0-9]{2}(-|\/|.)(0?[1-9]|1[0-2])(-|\/|.)((0?[1-9])|([1-2][0-9])|(3[0-1]))$/" // 89-08-28 | 89-8-8
        ];

        // Mon 4th Nov, 2020
        $dateFormat = 'D jS M, Y ';
        $newDate = "Date is wrong";
        $flash = false;

        foreach ($dateType as $key => $value) {
            if (preg_match($value, $date)) {
                $reDate = preg_split("/[\s\/\-\.]+/", $date);
                foreach ($reDate as $k => $v) {
                    if (strlen($v) === 1) {
                        $reDate[$k] = "0$v";
                    }
                }
                $reDate = implode("-", $reDate);
                $newDate = date($dateFormat, strtotime($reDate));
                $flash = true;
                break;
            }
        }
        if ($flash) {
            $date_now = new DateTime();
            $date2    = new DateTime($newDate);
            if ($date_now < $date2) {
                $newDate = "Date cannot greater than currently year";
            }
        }

        echo '  - ' . $field->getLabel() . ': ' . $date . ' -> ' .' after converted: ' . $newDate . "\n";
    }
}
