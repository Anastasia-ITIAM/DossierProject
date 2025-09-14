<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250914171541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trip_passengers (trip_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1645559CA5BC2E0E (trip_id), INDEX IDX_1645559CA76ED395 (user_id), PRIMARY KEY (trip_id, user_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE trip_passengers ADD CONSTRAINT FK_1645559CA5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trip_passengers ADD CONSTRAINT FK_1645559CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trip_passengers DROP FOREIGN KEY FK_1645559CA5BC2E0E');
        $this->addSql('ALTER TABLE trip_passengers DROP FOREIGN KEY FK_1645559CA76ED395');
        $this->addSql('DROP TABLE trip_passengers');
    }
}
