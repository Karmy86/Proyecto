<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416112521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE horario_febrero DROP FOREIGN KEY horario_febrero_ibfk_1');
        $this->addSql('DROP TABLE horario_febrero');
        $this->addSql('ALTER TABLE horario_enero DROP FOREIGN KEY horario_enero_ibfk_1');
        $this->addSql('DROP INDEX FK_id_paciente ON horario_enero');
        $this->addSql('ALTER TABLE horario_enero CHANGE id_paciente id_paciente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE horario_enero ADD CONSTRAINT FK_CCDF8226B021723 FOREIGN KEY (id_paciente_id) REFERENCES pacientes (id)');
        $this->addSql('CREATE INDEX IDX_CCDF8226B021723 ON horario_enero (id_paciente_id)');
        $this->addSql('ALTER TABLE pacientes CHANGE fecha_nacimiento fecha_nacimiento DATE DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE observaciones observaciones LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE horario_febrero (id INT NOT NULL, id_paciente INT DEFAULT NULL, dia DATE NOT NULL, hora TIME NOT NULL, estado TINYINT(1) NOT NULL, INDEX id_paciente (id_paciente), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE horario_febrero ADD CONSTRAINT horario_febrero_ibfk_1 FOREIGN KEY (id_paciente) REFERENCES pacientes (id)');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE horario_enero DROP FOREIGN KEY FK_CCDF8226B021723');
        $this->addSql('DROP INDEX IDX_CCDF8226B021723 ON horario_enero');
        $this->addSql('ALTER TABLE horario_enero CHANGE id_paciente_id id_paciente INT DEFAULT NULL');
        $this->addSql('ALTER TABLE horario_enero ADD CONSTRAINT horario_enero_ibfk_1 FOREIGN KEY (id_paciente) REFERENCES pacientes (id)');
        $this->addSql('CREATE INDEX FK_id_paciente ON horario_enero (id_paciente)');
        $this->addSql('ALTER TABLE pacientes CHANGE fecha_nacimiento fecha_nacimiento DATE DEFAULT \'NULL\', CHANGE email email VARCHAR(255) DEFAULT \'NULL\', CHANGE observaciones observaciones TEXT DEFAULT NULL');
    }
}
