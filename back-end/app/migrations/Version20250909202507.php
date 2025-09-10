<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250909202507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, license_plate VARCHAR(20) NOT NULL, registration_date DATE NOT NULL, model VARCHAR(50) NOT NULL, brand VARCHAR(50) NOT NULL, color VARCHAR(30) NOT NULL, fuel_type VARCHAR(255) NOT NULL, available_seats INT NOT NULL, custom_preferences VARCHAR(255) DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_773DE69DA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE driver_preference (id INT AUTO_INCREMENT NOT NULL, driver_id INT NOT NULL, music TINYINT(1) DEFAULT NULL, conversation TINYINT(1) DEFAULT NULL, pets_allowed TINYINT(1) DEFAULT NULL, air_conditioning TINYINT(1) DEFAULT NULL, smoker TINYINT(1) DEFAULT NULL, custom_preferences LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, trip_id INT NOT NULL, participation_date DATETIME NOT NULL, is_valid TINYINT(1) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, driver_id INT NOT NULL, author_id INT DEFAULT NULL, rating INT NOT NULL, comment LONGTEXT DEFAULT NULL, review_date DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, car_id INT NOT NULL, user_id INT NOT NULL, departure_address VARCHAR(255) NOT NULL, arrival_address VARCHAR(255) NOT NULL, departure_date DATE NOT NULL, departure_time TIME NOT NULL, arrival_time TIME NOT NULL, available_seats INT NOT NULL, price INT DEFAULT 0 NOT NULL, eco_friendly TINYINT(1) NOT NULL, status VARCHAR(255) NOT NULL, finished TINYINT(1) DEFAULT NULL, participant_validation TINYINT(1) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE trip_validation (id INT AUTO_INCREMENT NOT NULL, trip_id INT NOT NULL, user_id INT NOT NULL, status VARCHAR(255) NOT NULL, comment LONGTEXT DEFAULT NULL, validation_date DATETIME DEFAULT NULL, rating INT DEFAULT NULL, employee_validation VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(50) NOT NULL, first_name VARCHAR(50) DEFAULT NULL, last_name VARCHAR(50) DEFAULT NULL, birth_date DATE DEFAULT NULL, postal_address LONGTEXT DEFAULT NULL, phone VARCHAR(20) DEFAULT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, credits INT NOT NULL, role VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, profile_photo_url VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DA76ED395');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE driver_preference');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE trip');
        $this->addSql('DROP TABLE trip_validation');
        $this->addSql('DROP TABLE user');
    }
}
