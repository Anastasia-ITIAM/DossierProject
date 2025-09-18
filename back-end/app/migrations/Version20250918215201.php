<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250918215201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE driver_preference');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY `FK_7656F53BA76ED395`');
        $this->addSql('DROP INDEX IDX_7656F53BA76ED395 ON trip');
        $this->addSql('ALTER TABLE trip CHANGE user_id driver_id INT NOT NULL');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BC3423909 FOREIGN KEY (driver_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7656F53BC3423909 ON trip (driver_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE driver_preference (id INT AUTO_INCREMENT NOT NULL, driver_id INT NOT NULL, music TINYINT(1) DEFAULT NULL, conversation TINYINT(1) DEFAULT NULL, pets_allowed TINYINT(1) DEFAULT NULL, air_conditioning TINYINT(1) DEFAULT NULL, smoker TINYINT(1) DEFAULT NULL, custom_preferences LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BC3423909');
        $this->addSql('DROP INDEX IDX_7656F53BC3423909 ON trip');
        $this->addSql('ALTER TABLE trip CHANGE driver_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT `FK_7656F53BA76ED395` FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_7656F53BA76ED395 ON trip (user_id)');
    }
}
