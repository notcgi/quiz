<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240824142604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create quiz_results table with sequence for id';
    }

    public function up(Schema $schema): void
    {
        // Create sequence for quiz_results id
        $this->addSql('CREATE SEQUENCE quiz_results_id_seq INCREMENT BY 1 MINVALUE 1 START 1');

        // Create quiz_results table with id using the sequence
        $this->addSql('CREATE TABLE quiz_results (
            id INT NOT NULL DEFAULT NEXTVAL(\'quiz_results_id_seq\'), 
            results JSON NOT NULL, 
            PRIMARY KEY(id)
        )');
    }

    public function down(Schema $schema): void
    {
        // Drop quiz_results table and sequence
        $this->addSql('DROP TABLE quiz_results');
        $this->addSql('DROP SEQUENCE quiz_results_id_seq CASCADE');
    }
}