<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220405153152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE access_token_expiration ADD token VARCHAR(255) NOT NULL');
       
        $this->addSql('ALTER TABLE parcel_job ADD CONSTRAINT FK_99FC9A274F311658 FOREIGN KEY (dimensions_id) REFERENCES dimension (id)');
       
        $this->addSql('CREATE UNIQUE INDEX UNIQ_99FC9A274F311658 ON parcel_job (dimensions_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE access_token_expiration DROP token');
        $this->addSql('ALTER TABLE parcel_job DROP FOREIGN KEY FK_99FC9A27C53D18AF');
        $this->addSql('ALTER TABLE parcel_job DROP FOREIGN KEY FK_99FC9A274F311658');
        $this->addSql('DROP INDEX UNIQ_99FC9A27C53D18AF ON parcel_job');
        $this->addSql('DROP INDEX UNIQ_99FC9A274F311658 ON parcel_job');
    }
}
