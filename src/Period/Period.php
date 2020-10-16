<?php

namespace Jflahaut\Analytics\Period;


use DateTime;

class Period
{
    /**
     * @var DateTime
     */
    private $startDate;

    /**
     * @var DateTime
     */
    private $endDate;

    /**
     * Period constructor.
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @throws InvalidPeriod
     */
    private function __construct(DateTime $startDate, DateTime $endDate)
    {
        if ($startDate > $endDate) {
            throw InvalidPeriod::dateStartCannotBeAfterDateEnd($startDate, $endDate);
        }

        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param string $format
     * @return static
     * @throws InvalidPeriod
     */
    public static function create(string $startDate, string $endDate, string $format = 'Y-m-d H:i:s'): self
    {
        return new static(self::validateDate($format, $startDate), self::validateDate($format, $endDate));
    }

    /**
     * @param int $days
     * @return static
     * @throws InvalidPeriod
     */
    public static function days(int $days): self
    {
        $end = new DateTime(date('Y-m-d', strtotime('-1 days')) . '23:59:59');
        $start = new DateTime(date('Y-m-d', strtotime('- ' . $days . ' days')));

        return new static($start, $end);
    }

    /**
     * @param int $months
     * @return static
     * @throws InvalidPeriod
     */
    public static function months(int $months): self
    {
        $end = new DateTime(date('Y-m-d', strtotime('-1 days')) . '23:59:59');
        $start = new DateTime(date('Y-m-d', strtotime('- ' . $months . ' months -1 day')));

        return new static($start, $end);
    }

    /**
     * @param int $years
     * @return static
     * @throws InvalidPeriod
     */
    public static function years(int $years): self
    {
        $end = new DateTime(date('Y-m-d', strtotime('-1 days')) . '23:59:59');
        $start = new DateTime(date('Y-m-d', strtotime('- ' . $years . ' years -1 day')));

        return new static($start, $end);
    }

    /**
     * @param string $format
     * @param string $date
     * @return DateTime
     * @throws InvalidPeriod
     */
    private static function validateDate(string $format, string $date)
    {
        $dateTime = DateTime::createFromFormat($format, $date);

        if($dateTime && $dateTime->format($format) === $date) {
            return $dateTime;
        } else {
            throw InvalidPeriod::invalidDateFormat($format, $date);
        }
    }
}