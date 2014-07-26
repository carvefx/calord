<?php

namespace spec\Calord\Services;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Carbon\Carbon;

class CalendarServiceSpec extends ObjectBehavior
{
  function it_is_initializable()
  {
    $this->shouldHaveType('Calord\Services\CalendarService');
  }


  function let()
  {
    $this->setYear(2014);
    $this->setMonth(7);
  }

  function it_returns_the_date_for_the_first_day()
  {
    $date = Carbon::create(2014, 7, 1, 0);
    $returned_date = $this->getFirstDay();
    $returned_date->toDateTimeString()->shouldBe($date->toDateTimeString());
  }

  function it_retuns_the_date_for_the_first_day_of_a_specific_month()
  {
    $date = Carbon::create(2014, 7, 1, 0);
    $returned_date = $this->getFirstDayByYearMonth(2014, 7);
    $returned_date->toDateTimeString()->shouldBe($date->toDateTimeString());
  }

  function it_returns_the_date_for_the_last_day()
  {
    $date = Carbon::create(2014, 7, 31, 0);
    $returned_date = $this->getLastDay();
    $returned_date->toDateTimeString()->shouldBe($date->toDateTimeString());
  }

  function it_retuns_the_date_for_the_last_day_of_a_specific_month()
  {
    $date = Carbon::create(2014, 7, 31, 0);
    $returned_date = $this->getLastDayByYearMonth(2014, 7);
    $returned_date->toDateTimeString()->shouldBe($date->toDateTimeString());
  }

  function it_computes_the_calendar_for_a_given_month_and_year()
  {
    $weeks = [
        [
          'blank_days' => [30],
          'days' => [1, 2, 3, 4, 5, 6]
        ],
        [
          'days' => [7, 8, 9, 10, 11, 12, 13]
        ],
        [
          'days' => [14, 15, 16, 17, 18, 19, 20]
        ],
        [
          'days' => [21, 22, 23, 24, 25, 26, 27]
        ],
        [
          'blank_days' => [1, 2, 3],
          'days' => [28, 29, 30, 31]
        ]
    ];
    $this->getWeeks()->shouldReturn($weeks);
  }

  function it_computes_the_number_of_blank_days_for_a_given_week_of_a_month()
  {
    $this->getBlankDays()->shouldReturn(
      [
        'first_week' => [29, 30],
        'last_week' => [1, 2],
        ]
    );
  }


}
