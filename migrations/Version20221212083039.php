<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212083039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv ADD medecin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F864F31A84 FOREIGN KEY (medecin_id) REFERENCES docteur (id)');
        $this->addSql('CREATE INDEX IDX_10C31F864F31A84 ON rdv (medecin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F864F31A84');
        $this->addSql('DROP INDEX IDX_10C31F864F31A84 ON rdv');
        $this->addSql('ALTER TABLE rdv DROP medecin_id');
    }
}
