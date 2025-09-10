<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250910210515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, car_id INT NOT NULL, user_id INT NOT NULL, departure_address VARCHAR(255) NOT NULL, arrival_address VARCHAR(255) NOT NULL, departure_date DATE NOT NULL, departure_time TIME NOT NULL, arrival_time TIME NOT NULL, available_seats INT NOT NULL, price INT DEFAULT 0 NOT NULL, eco_friendly TINYINT(1) NOT NULL, status VARCHAR(255) NOT NULL, finished TINYINT(1) DEFAULT NULL, participant_validation TINYINT(1) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE trip');
    }
}
