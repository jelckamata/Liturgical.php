<?php
namespace JELCKama\Liturgical;

require __DIR__ . "/vendor/autoload.php";
use DateTime, DateTimeZone, DateInterval;

/**
 * Summary of DateTimeGet
 */
enum DateTimeGet: string {
    case Year = "y";
    case Month = "m";
    case Day = "d";
    case WeekDay = "w";
}
/**
 * Summary of get_date
 * @param DateTime $date
 * @param DateTimeGet $kind
 * @return int
 */
function get_date(DateTime $date, DateTimeGet $kind): int {
    return (int) $date->format($kind->value);
}
/**
 * Summary of make_date
 * @param int $year
 * @param int $month
 * @param int $day
 * @param DateTimeZone $timezone
 * @return DateTime
 */
function make_date(int $year = 1970, int $month = 1, int $day = 1, DateTimeZone $timezone = new DateTimeZone("asia/Tokyo")): DateTime {
    return (new DateTime())
    ->setTimezone($timezone)
    ->setDate($year, $month,  $day);
} 
/**
 * 日数から日付間隔型を生成
 * @param int $day 日数(デフォルトは1)
 * @return DateInterval
 */
function make_interval(int $day = 1): DateInterval {
    return new DateInterval("P{$day}D");
}
/**
 * 日時が基準時点よりも前であるか
 * @param DateTime $base 基準時点
 * @param DateTime $target 目的日時
 * @return bool
 */
function is_before(DateTime $base, DateTime $target): bool {
    return $base->getTimestamp() > $target->getTimestamp();
}
/**
 * 日時が基準時点よりも後であるか
 * @param DateTime $base 基準時点
 * @param DateTime $target 目的日時
 * @return bool
 */
function is_after(DateTime $base, DateTime $target): bool {
    return $base->getTimestamp() < $target->getTimestamp();
}
/**
 * 日時が基準時点と同じであるか
 * @param DateTime $base 基準時点
 * @param DateTime $target 目的日時
 * @return bool
 */
function is_same(DateTime $base, DateTime $target): bool {
    return $base->getTimestamp() == $target->getTimestamp();
}
/**
 * その日の日没時間をAPIから取得(蒲田教会のある東京基準)
 * @param DateTime $ofDate
 * @return DateTime
 */
function get_sunset(DateTime $ofDate): DateTime {
    $year = get_date($ofDate, DateTimeGet::Year);
    $month = get_date($ofDate, DateTimeGet::Month);
    $day = get_date($ofDate, DateTimeGet::Day);
    $zone = $ofDate->getTimezone()->getName();
    /**
 * @var string[][] $res
 */
    $res = json_decode(file_get_contents("https://api.sunrise-sunset.org/json?lat=35.6809591&lng=139.7673068&formatted=0&tzid={$zone}&date={$year}-{$month}-{$day}"));
    return new DateTime($res["result"]["sunset"]);

}
?>