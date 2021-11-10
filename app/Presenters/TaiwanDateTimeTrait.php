<?php

namespace App\Presenters;


use Illuminate\Support\Carbon;

trait TaiwanDateTimeTrait
{
    public function twYYYYMMDD(string $column): string
    {
        if (!isset($this->$column) || !$this->$column instanceof Carbon) {
            return "";
        }

        $year = $this::twYear($this->$column);


        return $year . $this->$column->format('m月d日 H點');
    }

    public static function twYear(Carbon $date)
    {
        $year = ((int)$date->format("Y")) - 1911;
        return $year . "年";
    }

    public static function month(Carbon $date): string
    {
        return $date->format("m") . " 月";
    }

    public static function day(Carbon $date): string
    {
        return $date->format("d") . " 日";
    }
}
