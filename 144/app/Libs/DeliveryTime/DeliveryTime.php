<?php

namespace App\Libs\DeliveryTime;

use App\Models\FreeDay;

class DeliveryTime
{
    protected $date;
    protected $time;
    private static $freeDays;

    public function __construct($datetime = null)
    {
        if ($datetime !== null) {
            $this->setTimestamp(strtotime($datetime));
        }
    }

    public function __toString()
    {
        return (string) $this->getDateTime();
    }

    public function setTimestamp($timestamp)
    {
        $this->date = date('Y-m-d', $timestamp);
        $this->time = date('H:i:s', $timestamp);
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }

    public function getWorkday(): DeliveryTime
    {
        return new DeliveryTime($this->workday($this->getDate()));
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getHour(): ?int
    {
        if ($this->time === null) {
            return null;
        }

        return (int) substr($this->getTime(), 0, 2);
    }

    public function isToday(): bool
    {
        return date('Y-m-d') == $this->date;
    }

    public function isTomorrow(): bool
    {
        return date('Y-m-d', strtotime('+1 day')) == $this->date;
    }

    public function isNextBusinessDay(): bool
    {
        if ($this->isAnUnofficialFreeDay()) {
            return false;
        }

        return $this->workday($this->getNextDay()) == $this->date;
    }

    public function isEmpty(): bool
    {
        return $this->date === null;
    }

    public function getDateTime(): ?string
    {
        if ($this->isEmpty()) {
            return null;
        }

        return $this->date . ' ' . $this->time;
    }

    protected function workday($datum)
    {
        if (self::$freeDays === null) {
            self::$freeDays = FreeDay::select('Datum')->pluck('Datum')->toArray();
        }

        $datum = date('Y-m-d', strtotime($datum));

        // Ha a következő nap, szabadnap (függetlenül attól, hogy saját, vagy hivatalos)
        if (in_array($datum, self::$freeDays)) {
            return $this->workday(date('Y-m-d', strtotime('+1 day', strtotime($datum))));
        }

        return $datum;
    }

    private function isAnUnofficialFreeDay(): bool
    {
        $unofficialFreeDays = FreeDay::select('Datum')->where('inner', 1)->pluck('Datum')->toArray();

        return in_array($this->getNextDay(), $unofficialFreeDays);
    }

    private function getNextDay()
    {
        return date('Y-m-d', strtotime('+1 day'));
    }
}
