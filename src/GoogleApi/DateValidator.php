<?php

namespace App\GoogleApi;

class DateValidator
{

    public function validate(string $date)
    {
        $date_arr = explode('-', $date);

        if (count($date_arr) == 3 && is_numeric($date_arr[0]) && is_numeric($date_arr[1]) && is_numeric($date_arr[2]) && strlen($date_arr[0]) === 4) {
            if ($this->checkYear($date_arr[0])) {
                if($this->checkDay($date_arr[2], $date_arr[1]))
                {
                    $today = new \DateTime();
                    if($today->format('Y-m-d') < $date)
                    {
                        return true;
                    }
                    else
                    {
                        return 'Negali buti praeities data';
                    }
                }
                else
                {
                    return 'Bloga diena arba menesis';
                }

            } else
                return 'Blogi metai(2018 arba 2019)';
        } else {
            return 'Blogas datos formatas (YYYY-MM-DD)';
        }
    }

    public function checkYear(int $year)
    {
        if ($year < 2020 && $year > 2017) {
            return true;
        } else {
            return false;
        }
    }

    public function checkDay(int $day, int $month)
    {
        $day31 = [1, 3, 5, 7, 8, 10, 12];
        $day30 = [4, 6, 9, 11];
        $day28 = 2;

        if (in_array($month, $day31) && $day < 32) {
            return true;
        } elseif (in_array($month, $day30) && $day < 31) {
            return true;
        } elseif ($day28 === $month && $day < 29) {
            return true;
        }
        else{
            return false;
        }
    }
}