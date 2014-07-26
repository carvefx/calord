<?php

namespace Calord\Services;

use Carbon\Carbon;

class CalendarService
{
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

  public function getWeeks()
  {
    $date = $this->getFirstDay();
    //$total_days = $date->daysInMonth();
  }

  public function getBlankDays()
  {
    $blank_days = [
      'first_week' => [],
      'last_week' => []
    ];
    $blank_days['first_week'] = $this->getFirstWeekBlanks();
    $blank_days['last_week'] = $this->getLastWeekBlanks();

    return $blank_days;
  }

  /**
   * @return array|bool
   */
  private function getFirstWeekBlanks()
  {
    $first_day = $this->getFirstDay();
    $day_of_week = $first_day->dayOfWeek;

    if ($day_of_week == $first_day->day) {
      return [];
    }

    $blank_days = [];
    for ($day = 0; $day < $day_of_week; $day++) {
      $blank_days[] = $first_day->subDays(1)->day;
    }

    sort($blank_days, SORT_NUMERIC);
    return array_values($blank_days);
  }

  /**
   * @return array|bool
   */
  private function getLastWeekBlanks()
  {
    $last_day = $this->getLastDay();
    $day_of_week = $last_day->dayOfWeek;

    if ($day_of_week == 6) {
      return [];
    }


    $blank_days = [];
    for ($day = 6; $day > $day_of_week; $day--) {
      $blank_days[] = $last_day->addDays(1)->day;
    }


    sort($blank_days, SORT_NUMERIC);
    return array_values($blank_days);
  }
}
