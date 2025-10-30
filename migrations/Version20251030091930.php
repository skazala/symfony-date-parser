<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251030091930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create parsed_dates table for storing parsed date info';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE parsed_dates (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            date_string VARCHAR(255) NOT NULL,
            century INTEGER NOT NULL,
            year INTEGER NOT NULL,
            month VARCHAR(255) NOT NULL,
            day INTEGER NOT NULL,
            day_of_week VARCHAR(255) NOT NULL,
            parse_count INTEGER NOT NULL
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE parsed_dates');
    }
}
