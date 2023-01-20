<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230105130955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE docteur ADD compte_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE docteur ADD CONSTRAINT FK_83A7A4391F09EFC3 FOREIGN KEY (compte_user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_83A7A4391F09EFC3 ON docteur (compte_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE docteur DROP FOREIGN KEY FK_83A7A4391F09EFC3');
        $this->addSql('DROP INDEX UNIQ_83A7A4391F09EFC3 ON docteur');
        $this->addSql('ALTER TABLE docteur DROP compte_user_id');
    }
}
