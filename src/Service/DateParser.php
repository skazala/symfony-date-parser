<?php

namespace App\Service;

use DateTimeImmutable;
use InvalidArgumentException;
use Psr\Cache\CacheItemPoolInterface;

class DateParser
{
    public function __construct(private CacheItemPoolInterface $cache) {}

    /**
     * Parses a date string in `DD.MM.YYYY` format and returns structured date info.
     *
     * @param string $date
     * 
     * @return array{
     *     date: string,
     *     century: int,
     *     year: int,
     *     month: string,
     *     day: int,
     *     dayOfWeek: string
     * }
     *
     * @throws InvalidArgumentException
     */
    public function parse(string $date): array
    {
        $date = trim($date);

        $cacheItem = $this->cache->getItem('date_parser_' . md5($date));
        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        if (!preg_match('/^([0-3]?\d)\.([0-1]?\d)\.(\d{4})$/', $date, $m)) {
            throw new InvalidArgumentException('Invalid date format. Expected DD.MM.YYYY');
        }

        [$full, $d, $mo, $y] = $m;

        $day = (int)$d;
        $month = (int)$mo;
        $year = (int)$y;

        if ($year < 1000 || $year > 9999) {
            throw new InvalidArgumentException('Year must be between 1000 and 9999');
        }

        $dt = DateTimeImmutable::createFromFormat('d.m.Y', sprintf('%02d.%02d.%04d', $day, $month, $year));
        $errors = DateTimeImmutable::getLastErrors();
        if (($dt === false) || (is_array($errors))) {
            throw new InvalidArgumentException('Invalid calendar date');
        }

        $century = (int)ceil($year / 100);

        $result = [
            'date' => $date,
            'century' => $century,
            'year' => $year,
            'month' => $dt->format('F'),
            'day' => (int)$dt->format('j'),
            'dayOfWeek' => $dt->format('l'),
        ];

        $cacheItem->set($result)->expiresAfter(3600);
        $this->cache->save($cacheItem);

        return $result;
    }
}
