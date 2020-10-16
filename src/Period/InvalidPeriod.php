<?php

namespace Jflahaut\Analytics\Period;

use DateTime;
use Exception;

class InvalidPeriod extends Exception
{
    public static function invalidDateFormat(string $format, string $date): self
    {
        return new static('The date ' .$date. ' is not compatible with the format '. $format);
    }

    public static function dateStartCannotBeAfterDateEnd(DateTime $startDate, DateTime $endDate): self
    {
        return new static('Start date ' .$startDate->format('Y-m-d'). ' cannot be after end date ' .$endDate->format('Y-m-d'));
    }
}