<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240824142605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Seed questions and answers';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO question (id, question_text) VALUES (1, '1 + 1 = ')");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (1, 1, '3', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (2, 1, '2', true)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (3, 1, '0', false)");

        $this->addSql("INSERT INTO question (id, question_text) VALUES (2, '2 + 2 = ')");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (4, 2, '4', true)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (5, 2, '3 + 1', true)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (6, 2, '10', false)");

        $this->addSql("INSERT INTO question (id, question_text) VALUES (3, '3 + 3 = ')");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (7, 3, '1 + 5', true)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (8, 3, '1', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (9, 3, '6', true)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (10, 3, '2 + 4', true)");

        $this->addSql("INSERT INTO question (id, question_text) VALUES (4, '4 + 4 = ')");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (11, 4, '8', true)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (12, 4, '4', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (13, 4, '0', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (14, 4, '0 + 8', true)");

        $this->addSql("INSERT INTO question (id, question_text) VALUES (5, '5 + 5 = ')");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (15, 5, '6', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (16, 5, '18', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (17, 5, '10', true)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (18, 5, '9', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (19, 5, '0', false)");

        $this->addSql("INSERT INTO question (id, question_text) VALUES (6, '6 + 6 = ')");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (20, 6, '3', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (21, 6, '9', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (22, 6, '0', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (23, 6, '12', true)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (24, 6, '5 + 7', true)");

        $this->addSql("INSERT INTO question (id, question_text) VALUES (7, '7 + 7 = ')");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (25, 7, '5', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (26, 7, '14', true)");

        $this->addSql("INSERT INTO question (id, question_text) VALUES (8, '8 + 8 = ')");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (27, 8, '16', true)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (28, 8, '12', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (29, 8, '9', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (30, 8, '5', false)");

        $this->addSql("INSERT INTO question (id, question_text) VALUES (9, '9 + 9 = ')");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (31, 9, '18', true)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (32, 9, '9', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (33, 9, '17 + 1', true)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (34, 9, '2 + 16', true)");

        $this->addSql("INSERT INTO question (id, question_text) VALUES (10, '10 + 10 = ')");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (35, 10, '0', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (36, 10, '2', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (37, 10, '8', false)");
        $this->addSql("INSERT INTO answer (id, question_id, answer_text, is_correct) VALUES (38, 10, '20', true)");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE question');
        $this->addSql('TRUNCATE TABLE answer');
    }
}