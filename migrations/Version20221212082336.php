<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212082336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_consultation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, duree INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_consultation_docteur (type_consultation_id INT NOT NULL, docteur_id INT NOT NULL, INDEX IDX_804B5F1195CBF8AB (type_consultation_id), INDEX IDX_804B5F11CF22540A (docteur_id), PRIMARY KEY(type_consultation_id, docteur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE type_consultation_docteur ADD CONSTRAINT FK_804B5F1195CBF8AB FOREIGN KEY (type_consultation_id) REFERENCES type_consultation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_consultation_docteur ADD CONSTRAINT FK_804B5F11CF22540A FOREIGN KEY (docteur_id) REFERENCES docteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE horaires ADD CONSTRAINT FK_39B7118F4F31A84 FOREIGN KEY (medecin_id) REFERENCES docteur (id)');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F864F31A84');
        $this->addSql('DROP INDEX IDX_10C31F864F31A84 ON rdv');
        $this->addSql('ALTER TABLE rdv ADD typeconsultation_id INT DEFAULT NULL, CHANGE medecin_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86E84518C4 FOREIGN KEY (typeconsultation_id) REFERENCES type_consultation (id)');
        $this->addSql('CREATE INDEX IDX_10C31F86A76ED395 ON rdv (user_id)');
        $this->addSql('CREATE INDEX IDX_10C31F86E84518C4 ON rdv (typeconsultation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86E84518C4');
        $this->addSql('ALTER TABLE type_consultation_docteur DROP FOREIGN KEY FK_804B5F1195CBF8AB');
        $this->addSql('ALTER TABLE type_consultation_docteur DROP FOREIGN KEY FK_804B5F11CF22540A');
        $this->addSql('DROP TABLE type_consultation');
        $this->addSql('DROP TABLE type_consultation_docteur');
        $this->addSql('ALTER TABLE horaires DROP FOREIGN KEY FK_39B7118F4F31A84');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86A76ED395');
        $this->addSql('DROP INDEX IDX_10C31F86A76ED395 ON rdv');
        $this->addSql('DROP INDEX IDX_10C31F86E84518C4 ON rdv');
        $this->addSql('ALTER TABLE rdv DROP typeconsultation_id, CHANGE user_id medecin_id INT NOT NULL');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F864F31A84 FOREIGN KEY (medecin_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_10C31F864F31A84 ON rdv (medecin_id)');
    }
}
