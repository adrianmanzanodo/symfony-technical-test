<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220718174841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE director_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE director (id INT NOT NULL, peliculas_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, fecha_nacimiento DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1E90D3F09EDD74B8 ON director (peliculas_id)');
        $this->addSql('ALTER TABLE director ADD CONSTRAINT FK_1E90D3F09EDD74B8 FOREIGN KEY (peliculas_id) REFERENCES peliculas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE director_id_seq CASCADE');
        $this->addSql('DROP TABLE director');
    }
}
