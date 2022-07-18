<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220718164305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE actor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE peliculas_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE actor (id INT NOT NULL, peliculas_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, fecha_nacimiento DATE NOT NULL, fecha_fallecimiento DATE NOT NULL, lugar_nacimiento VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_447556F99EDD74B8 ON actor (peliculas_id)');
        $this->addSql('CREATE TABLE peliculas (id INT NOT NULL, titulo VARCHAR(150) NOT NULL, fecha_publicacion DATE DEFAULT NULL, genero VARCHAR(50) NOT NULL, duracion INT NOT NULL, productora VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE actor ADD CONSTRAINT FK_447556F99EDD74B8 FOREIGN KEY (peliculas_id) REFERENCES peliculas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE actor DROP CONSTRAINT FK_447556F99EDD74B8');
        $this->addSql('DROP SEQUENCE actor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE peliculas_id_seq CASCADE');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE peliculas');
    }
}
