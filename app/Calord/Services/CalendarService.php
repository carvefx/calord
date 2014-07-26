<?php

namespace Calord\Services;

use Carbon\Carbon;

class CalendarService
{

  const DAYS_IN_WEEK = 7;

  const WEEKS_IN_MONTH = 6;

  const DAY_SLOTS_IN_MONTH = 42;

  /**
   * @var
   */
  private $month;

  /**
   * @var
   */
  private $year;

  /**
   * @param mixed $month
   */
  public function setMonth($month)
  {
    $this->month = $month;
  }

  /**
   * @return mixed
   */
  public function getMonth()
  {
    return $this->month;
  }

  /**
   * @param mixed $year
   */
  public function setYear($year)
  {
    $this->year = $year;
  }

  /**
   * @return mixed
   */
  public function getYear()
  {
    return $this->year;
  }

  /**
   * @return static
   */
  public function getFirstDay()
  {
    return $this->getFirstDayByYearMonth($this->year, $this->month);
  }

  /**
   * @param $year
   * @param $month
   * @return static
   */
  public function getFirstDayByYearMonth($year, $month)
  {
    return Carbon::create($year, $month, 1, 0);
  }

  /**
   * @return static
   */
  public function getLastDay()
  {
    return $this->getLastDayByYearMonth($this->year, $this->month);
  }

  /**
   * @param $year
   * @param $month
   * @return static
   */
  public function getLastDayByYearMonth($year, $month)
  {
    $date = Carbon::create($year, $month, 1, 0);
    $last = $date->daysInMonth;
    $date->setDate($year, $month, $last, 0);

    return $date;
  }

  /**
   * @return array
   */
  public function getCalendar()
  {
    $last_day = $this->getLastDay();
    $last_week = $last_day->weekOfMonth;

    $weeks = [];
    for($week = 1; $week <= $last_week; $week++) {
      $weeks[] = [
        'blank_days' => $this->getBlankDaysByWeek($week),
        'days' => $this->getDaysByWeek($week)
      ];
    }

    return $weeks;

    $processed_weeks = count($weeks);
    if($processed_weeks < 6) {
      $this->fillBlankWeeks($weeks);
    }

    return $weeks;

  }

  /**
   * @param $week
   * @return array
   */
  public function getBlankDaysByWeek($week)
  {
    $blank_days = [];
    if($week == 1) {
      $start_date = $this->getFirstDay();
      if($start_date->day == $start_date->dayOfWeek) {
        return $blank_days;
      }

      $missing_days = $start_date->dayOfWeek;
      for($day = 1; $day <= $missing_days; $day++) {
        $blank_days[] = $start_date->subDay(1)->day;
      }
    } else {
      $last_date = $this->getLastDay();
      if($last_date->weekOfMonth != $week) {
        return $blank_days;
      }

      $day = $last_date->dayOfWeek;
      for($day; $day < 6; $day++) {
        $blank_days[] = $last_date->addDay(1)->day;
      }
    }

    sort($blank_days, SORT_NUMERIC);
    return array_values($blank_days);
  }

  /**
   * @param $week
   * @return array
   */
  public function getDaysByWeek($week)
  {
    $days = [];
    $start_date = $this->getFirstDay();

    if($week != $start_date->weekOfMonth) {
      $start_date = $this->getFirstDayByWeek($week);
    }

    $days[] = $start_date->day;
    $max_days = 6;
    $end_date = $this->getLastDay();

    if($end_date->weekOfMonth == $week) {
      $max_days = $end_date->dayOfWeek;
    }

    for($day = $start_date->dayOfWeek; $day < $max_days; $day++) {
      $days[] = $start_date->addDays(1)->day;
    }

    return $days;
  }

  /**
   * @param $week
   * @return static
   */
  public function getFirstDayByWeek($week)
  {
    $first_day = $this->getFirstDay();

    if ($week == 1) {
      return $first_day;
    }

    $week = $first_day->addWeeks($week - 1);
    $day_of_week = $week->dayOfWeek;

    if ($day_of_week == 1) {
      return $week;
    }

    return $week->subDays($day_of_week);
  }

  /**
   * @param $week
   * @return bool
   */
  public function isFirstWeek($week)
  {
    $first_day = $this->getFirstDay();

    if ($first_day->weekOfMonth == $week) {
      return true;
    }

    return false;
  }

  /**
   * @param $week
   * @return bool
   */
  public function isLastWeek($week)
  {
    $last_day = $this->getLastDay();

    if ($last_day->weekOfMonth == $week) {
      return true;
    }

    return false;
  }
}
