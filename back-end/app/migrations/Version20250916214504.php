<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250916214504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, license_plate VARCHAR(20) NOT NULL, registration_date DATE NOT NULL, model VARCHAR(50) NOT NULL, brand VARCHAR(50) NOT NULL, color VARCHAR(30) NOT NULL, fuel_type VARCHAR(255) NOT NULL, available_seats INT NOT NULL, custom_preferences VARCHAR(255) DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_773DE69DA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, car_id INT NOT NULL, departure_address VARCHAR(255) NOT NULL, arrival_address VARCHAR(255) NOT NULL, departure_date DATE NOT NULL, departure_time TIME NOT NULL, arrival_time TIME NOT NULL, available_seats INT NOT NULL, price INT DEFAULT 0 NOT NULL, eco_friendly TINYINT(1) NOT NULL, status VARCHAR(255) NOT NULL, finished TINYINT(1) DEFAULT NULL, participant_validation TINYINT(1) DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_7656F53BA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE trip_passengers (trip_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1645559CA5BC2E0E (trip_id), INDEX IDX_1645559CA76ED395 (user_id), PRIMARY KEY (trip_id, user_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trip_passengers ADD CONSTRAINT FK_1645559CA5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trip_passengers ADD CONSTRAINT FK_1645559CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DA76ED395');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BA76ED395');
        $this->addSql('ALTER TABLE trip_passengers DROP FOREIGN KEY FK_1645559CA5BC2E0E');
        $this->addSql('ALTER TABLE trip_passengers DROP FOREIGN KEY FK_1645559CA76ED395');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE trip');
        $this->addSql('DROP TABLE trip_passengers');
    }
}
