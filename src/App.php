<?php

namespace Quest;

use DateTime;
use Quest\contracts\Input;
use Quest\fields\DateOfBirth;
use Quest\fields\FirstName;
use Quest\fields\LastName;
use Quest\fields\LicenseExpiry;

date_default_timezone_set('UTC');
class App
{

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

    /**
     * @var String
     */
    private string $convertDOB = "";

    /**
     * @var String
     */
    private string $convertDE = "";




    public function run()
    {
        $this->createFields();
        $this->askQuestions();
        $this->showResponses();
    }

    private function createFields(): void
    {
        foreach (self::QUESTIONS as $questionClass) {
            $this->fields[] = new $questionClass();
        }
    }

    private function askQuestions(): void
    {
        foreach ($this->fields as $field) {
            $field->getInput();
            if ($field instanceof DateOfBirth || $field instanceof LicenseExpiry) {
                $this->checkDateFormat($field);
            }
        }
    }

    private function showResponses(): void
    {
        echo "\nResponses:\n";
        foreach ($this->fields as $field) {
            // Validate input date
            if ($field instanceof DateOfBirth) {
                echo '  - ' . $field->getLabel() . ': ' . $this->convertDOB . "\n";
            } else if($field instanceof LicenseExpiry) {
                echo '  - ' . $field->getLabel() . ': ' . $this->convertDE . "\n";
            } else {
                echo '  - ' . $field->getLabel() . ': ' . $field->getValue() . "\n";
            }
        }
        echo "\nThank You!\n\n";
    }

    private function checkDateFormat($field): void
    {
        try {
            $date = trim($field->getValue());
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
                $mess =  $field->getLabel() . ' ' . $date . ' was wrong format.' . "\n";
                throw new \Exception($mess);
                exit();
            }

            if ($field instanceof DateOfBirth) {
                $this->convertDOB = $newDate;
            } else {
                $this->convertDE = $newDate;
            }

        } catch (\Exception $e) {
            echo 'Error message: ' . $e->getMessage();
            exit();
        }
    }
}
