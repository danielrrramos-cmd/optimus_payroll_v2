<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260420123940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empleados DROP FOREIGN KEY `empleados_ibfk_1`');
        $this->addSql('ALTER TABLE empleados CHANGE apellidos apellidos VARCHAR(100) NOT NULL');
        $this->addSql('DROP INDEX empresa_id ON empleados');
        $this->addSql('CREATE INDEX IDX_9EB2266C521E1991 ON empleados (empresa_id)');
        $this->addSql('ALTER TABLE empleados ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (empresa_id) REFERENCES empresas (id)');
        $this->addSql('ALTER TABLE empresas DROP email, CHANGE nombre nombre VARCHAR(255) NOT NULL, CHANGE cif cif VARCHAR(20) NOT NULL, CHANGE direccion direccion VARCHAR(255) NOT NULL, CHANGE telefono telefono VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE nominas DROP FOREIGN KEY `nominas_ibfk_1`');
        $this->addSql('ALTER TABLE nominas DROP FOREIGN KEY `nominas_ibfk_2`');
        $this->addSql('DROP INDEX empresa_id ON nominas');
        $this->addSql('CREATE INDEX IDX_6F68C276521E1991 ON nominas (empresa_id)');
        $this->addSql('DROP INDEX empleado_id ON nominas');
        $this->addSql('CREATE INDEX IDX_6F68C276952BE730 ON nominas (empleado_id)');
        $this->addSql('ALTER TABLE nominas ADD CONSTRAINT `nominas_ibfk_1` FOREIGN KEY (empresa_id) REFERENCES empresas (id)');
        $this->addSql('ALTER TABLE nominas ADD CONSTRAINT `nominas_ibfk_2` FOREIGN KEY (empleado_id) REFERENCES empleados (id)');
        $this->addSql('ALTER TABLE usuarios DROP FOREIGN KEY `usuarios_ibfk_1`');
        $this->addSql('ALTER TABLE usuarios CHANGE usuario usuario VARCHAR(100) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EF687F22265B05D ON usuarios (usuario)');
        $this->addSql('DROP INDEX empresa_id ON usuarios');
        $this->addSql('CREATE INDEX IDX_EF687F2521E1991 ON usuarios (empresa_id)');
        $this->addSql('ALTER TABLE usuarios ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (empresa_id) REFERENCES empresas (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empleados DROP FOREIGN KEY FK_9EB2266C521E1991');
        $this->addSql('ALTER TABLE empleados CHANGE apellidos apellidos VARCHAR(150) NOT NULL');
        $this->addSql('DROP INDEX idx_9eb2266c521e1991 ON empleados');
        $this->addSql('CREATE INDEX empresa_id ON empleados (empresa_id)');
        $this->addSql('ALTER TABLE empleados ADD CONSTRAINT FK_9EB2266C521E1991 FOREIGN KEY (empresa_id) REFERENCES empresas (id)');
        $this->addSql('ALTER TABLE empresas ADD email VARCHAR(100) DEFAULT NULL, CHANGE nombre nombre VARCHAR(150) NOT NULL, CHANGE cif cif VARCHAR(20) DEFAULT NULL, CHANGE direccion direccion VARCHAR(255) DEFAULT NULL, CHANGE telefono telefono VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE nominas DROP FOREIGN KEY FK_6F68C276521E1991');
        $this->addSql('ALTER TABLE nominas DROP FOREIGN KEY FK_6F68C276952BE730');
        $this->addSql('DROP INDEX idx_6f68c276521e1991 ON nominas');
        $this->addSql('CREATE INDEX empresa_id ON nominas (empresa_id)');
        $this->addSql('DROP INDEX idx_6f68c276952be730 ON nominas');
        $this->addSql('CREATE INDEX empleado_id ON nominas (empleado_id)');
        $this->addSql('ALTER TABLE nominas ADD CONSTRAINT FK_6F68C276521E1991 FOREIGN KEY (empresa_id) REFERENCES empresas (id)');
        $this->addSql('ALTER TABLE nominas ADD CONSTRAINT FK_6F68C276952BE730 FOREIGN KEY (empleado_id) REFERENCES empleados (id)');
        $this->addSql('DROP INDEX UNIQ_EF687F22265B05D ON usuarios');
        $this->addSql('ALTER TABLE usuarios DROP FOREIGN KEY FK_EF687F2521E1991');
        $this->addSql('ALTER TABLE usuarios CHANGE usuario usuario VARCHAR(50) NOT NULL');
        $this->addSql('DROP INDEX idx_ef687f2521e1991 ON usuarios');
        $this->addSql('CREATE INDEX empresa_id ON usuarios (empresa_id)');
        $this->addSql('ALTER TABLE usuarios ADD CONSTRAINT FK_EF687F2521E1991 FOREIGN KEY (empresa_id) REFERENCES empresas (id)');
    }
}
