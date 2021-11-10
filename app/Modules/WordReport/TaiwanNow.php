<?php


namespace App\Modules\WordReport;


use App\Presenters\TaiwanDateTimeTrait;
use Illuminate\Support\Carbon;

class TaiwanNow
{
    use TaiwanDateTimeTrait;

    protected static $now;

    public static function yearText(): string
    {
        return self::twYear(self::getNow());
    }

    protected static function getNow(): Carbon
    {
        if (self::$now) {
            return self::$now;
        }
        self::$now = now();
        return self::$now;
    }

    public static function monthText(): string
    {
        return self::month(self::getNow());
    }

    public static function dayText(): string
    {
        return self::day(self::getNow());
    }
}
