<?php
namespace JELCKama\Liturgical;

require __DIR__ . "/vendor/autoload.php";
use DateTime;

/**
 * 待降節第一主日の日付を計算
 * @param int $year 取得したい年
 * @param bool $isLit その年表記が教会年であるか否(世俗年)か
 * @return DateTime
 */
function comp_advent_first(int $year, bool $isLit = false): DateTime {
    $p_year = $isLit ? $year - 1 : $year;
    $date1131 = make_date($p_year, 11,  31);
    $weekday = get_date($date1131,DateTimeGet::WeekDay);
    if($weekday == 0){
        return $date1131;
    }else if($weekday <= 3){
        return $date1131->sub(make_interval($weekday));
    }else{
        return $date1131->add(make_interval(7 - $weekday));
    }

}
/**
 * 聖家族の日の日付を計算
 * @param int $year 取得したい年
 * @param bool $isLit その年表記が教会年であるか否(世俗年)か
 * @return DateTime
 */
function comp_st_family(int $year, bool $isLit = false): DateTime {
    $p_year = $isLit ? $year - 1 : $year;
    $dateChristmas = make_date($p_year, 12,  25);
    $weekday = get_date($dateChristmas,DateTimeGet::WeekDay);
    if($weekday == 0){
        return make_date($p_year, 12,  30);
    }else{
        return $dateChristmas->add(make_interval(7 - $weekday));
    }
}
function comp_ash_wednesday(int $year): DateTime {
    return comp_easter($year)->sub(make_interval(46));

}
/**
 * Summary of comp_palm_sunday
 * @param int $year
 * @return DateTime
 */
function comp_palm_sunday(int $year): DateTime {
    return comp_easter($year)->sub(make_interval(7));
}
/**
 * Summary of comp_easter
 * @param int $year
 * @return DateTime
 */
function comp_easter(int $year): DateTime {
    $a = $year % 19;
    $b = intval($year / 100);
    $c = $year % 100;
    $d = intval($b / 4);
    $e = $b % 4;
    $f = intval(($b + 8) / 25);
    $g = intval(($b - $f + 1) / 3);
    $h = (19 * $a + $b - $d - $g + 15) % 30;
    $i = intval($c / 4);
    $k = $c % 4;
    $ll = (32 + 2 *$e + 2 * $i - $h -$k) % 7;
    $m = intval(($a + 11 * $h + 22 * $ll) / 451);
    $mm = intval(($h + $ll - 7 * $m + 114) / 31);
    $dd = (($h + $ll - 7 * $m + 114) % 31) + 1;


    return make_date($year, $mm, $dd);
}
function comp_ascension(int $year): DateTime {
    return comp_easter($year)->add(make_interval(39));
}
/**
 * Summary of comp_pentecost
 * @param int $year
 * @return DateTime
 */
function comp_pentecost(int $year): DateTime {
    return comp_easter($year)->add(make_interval(49));
}
/**
 * Summary of comp_trinity
 * @param int $year
 * @return DateTime
 */
function comp_trinity(int $year): DateTime{
    return comp_pentecost($year)->add(make_interval(7));
}


/**
 * イブであるか否か(蒲田教会のある東京基準)
 * @param DateTime $ofdate
 * @return bool
 */
function is_eve(DateTime $ofdate): bool {
    if(is_before(get_sunset($ofdate), $ofdate)){
        return false;
    }
    return true;
}
/**
 * 教会時上の日付を取得(蒲田教会のある東京基準)
 * @param DateTime $ofDate
 * @return DateTime
 */
function get_lit_day(DateTime $ofDate): DateTime{
    $year = get_date($ofDate, DateTimeGet::Year);
    $month = get_date($ofDate, DateTimeGet::Month);
    $day = get_date($ofDate, DateTimeGet::Day);
    $zone = $ofDate->getTimezone();
    if(is_eve($ofDate)){
        return make_date($year, $month, $day + 1, $zone);
    }else{
        return make_date($year, $month, $day, $zone);
        
    }
}
/**
 * イブの開始時間すなわち日没時間を取得(蒲田教会のある東京基準)
 * @param DateTime $ofDate
 * @return DateTime
 */
function get_eve_start(DateTime $ofDate): DateTime {
    return get_sunset($ofDate->sub(make_interval()));
}

?>