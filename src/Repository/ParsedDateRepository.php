<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;

class ParsedDateRepository
{
    public function __construct(private Connection $connection) {}

    public function incrementCount(array $parsed): void
    {
        $exists = $this->connection->fetchAssociative(
            'SELECT parse_count FROM parsed_dates WHERE date_string = ?',
            [$parsed['date']]
        );

        if ($exists) {
            $this->connection->executeStatement(
                'UPDATE parsed_dates SET parse_count = parse_count + 1 WHERE date_string = ?',
                [$parsed['date']]
            );
        } else {
            $this->connection->insert('parsed_dates', [
                'date_string'  => $parsed['date'],
                'century'      => $parsed['century'],
                'year'         => $parsed['year'],
                'month'        => $parsed['month'],
                'day'          => $parsed['day'],
                'day_of_week'  => $parsed['dayOfWeek'],
                'parse_count'  => 1,
            ]);
        }
    }

    public function findAllParsed(): array
    {
        return $this->connection->fetchAllAssociative(
            'SELECT 
             date_string AS date,
             century,
             year,
             month,
             day,
             day_of_week AS dayOfWeek,
             parse_count AS count
         FROM parsed_dates
         ORDER BY count DESC'
        );
    }
}
