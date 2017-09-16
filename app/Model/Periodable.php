<?php

namespace App\Model;

use App;
use DateTime;

/**
 * Trait Periodable
 * @package App\Model
 * @property int|null $start_month начало, месяц
 * @property int|null $start_year начало, год
 * @property int|null $end_month окончание работы, месяц
 * @property int|null $end_year окончание работы, год
 */
trait Periodable {

  function period(): string {

    $res = "";
    if ($this->start_year) {

      //начало
      if ($this->start_month) {
        $res .= __($this->monthName($this->start_month)) . ' ';
      }
      $res .= $this->start_year;
      $res .= " – ";


      //конец
      if ($this->end_year) {
        if ($this->end_month) {
          $res .= Month::text($this->end_month) . ' ';
        }
        $res .= $this->end_year;
      } else {
        $res .= __('по настоящее время');
      }
    }

    return $res;
  }

  /**
   * @return null|string
   */
  function periodInterval() {
    $res = null;
    if ($start_year = $this->start_year) {

      $start_month = $this->start_month ? $this->start_month : 1;
      $start = new DateTime("{$start_year}-{$start_month}-01");

      if ($end_year = $this->end_year) {
        $end_month = $this->end_month ? $this->end_month : 1;
        $end = new DateTime("{$end_year}-{$end_month}-01");
      } else {
        $end = new DateTime();
      }

      $interval = $start->diff($end);

      $years = $interval->format('%y');
      $months = $interval->format('%m');

      $parts = [];
      if ($years) $parts[] = years_count($years);
      if ($months) $parts[] = months_count($months);
      $res = implode(' ', $parts);

    }

    return $res;
  }

  private function monthName($monthNum) {
    $time = mktime(0, 0, 0, $monthNum, 1);
    return date('F', $time);
  }

}