<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250916214027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY `FK_773DE69DA76ED395`');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY `FK_7656F53BA76ED395`');
        $this->addSql('ALTER TABLE trip_passengers DROP FOREIGN KEY `FK_1645559CA5BC2E0E`');
        $this->addSql('ALTER TABLE trip_passengers DROP FOREIGN KEY `FK_1645559CA76ED395`');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE driver_preference');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE trip');
        $this->addSql('DROP TABLE trip_passengers');
        $this->addSql('DROP TABLE trip_validation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, license_plate VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, registration_date DATE NOT NULL, model VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, brand VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, color VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, fuel_type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, available_seats INT NOT NULL, custom_preferences VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, user_id INT NOT NULL, INDEX IDX_773DE69DA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE driver_preference (id INT AUTO_INCREMENT NOT NULL, driver_id INT NOT NULL, music TINYINT(1) DEFAULT NULL, conversation TINYINT(1) DEFAULT NULL, pets_allowed TINYINT(1) DEFAULT NULL, air_conditioning TINYINT(1) DEFAULT NULL, smoker TINYINT(1) DEFAULT NULL, custom_preferences LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, trip_id INT NOT NULL, participation_date DATETIME NOT NULL, is_valid TINYINT(1) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, car_id INT NOT NULL, user_id INT NOT NULL, departure_address VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, arrival_address VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, departure_date DATE NOT NULL, departure_time TIME NOT NULL, arrival_time TIME NOT NULL, available_seats INT NOT NULL, price INT DEFAULT 0 NOT NULL, eco_friendly TINYINT(1) NOT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, finished TINYINT(1) DEFAULT NULL, participant_validation TINYINT(1) DEFAULT NULL, INDEX IDX_7656F53BA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE trip_passengers (trip_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1645559CA5BC2E0E (trip_id), INDEX IDX_1645559CA76ED395 (user_id), PRIMARY KEY (trip_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE trip_validation (id INT AUTO_INCREMENT NOT NULL, trip_id INT NOT NULL, user_id INT NOT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, comment LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, validation_date DATETIME DEFAULT NULL, rating INT DEFAULT NULL, employee_validation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT `FK_773DE69DA76ED395` FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT `FK_7656F53BA76ED395` FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE trip_passengers ADD CONSTRAINT `FK_1645559CA5BC2E0E` FOREIGN KEY (trip_id) REFERENCES trip (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trip_passengers ADD CONSTRAINT `FK_1645559CA76ED395` FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
