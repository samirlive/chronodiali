<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220315181017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address1 VARCHAR(255) NOT NULL, address2 VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, postcode VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parcel_job (id INT AUTO_INCREMENT NOT NULL, is_pickup_required TINYINT(1) DEFAULT NULL, pickup_service_type VARCHAR(255) DEFAULT NULL, pickup_service_level VARCHAR(255) DEFAULT NULL, pickup_address_id INT DEFAULT NULL, pickup_date DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', delivery_start_date DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', delivery_instructions LONGTEXT DEFAULT NULL, weight DOUBLE PRECISION NOT NULL, size VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reference_order (id INT AUTO_INCREMENT NOT NULL, merchant_order_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD to_recipient_id INT DEFAULT NULL, ADD from_expediter_id INT DEFAULT NULL, ADD reference_id INT DEFAULT NULL, ADD parcel_job_id INT DEFAULT NULL, ADD graphql_api_query LONGTEXT DEFAULT NULL, CHANGE graph_qlquery rest_api_query LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993983DBA2CA4 FOREIGN KEY (to_recipient_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939881E691FC FOREIGN KEY (from_expediter_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993981645DEA9 FOREIGN KEY (reference_id) REFERENCES reference_order (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939864E6496B FOREIGN KEY (parcel_job_id) REFERENCES parcel_job (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F52993983DBA2CA4 ON `order` (to_recipient_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F529939881E691FC ON `order` (from_expediter_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F52993981645DEA9 ON `order` (reference_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F529939864E6496B ON `order` (parcel_job_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993983DBA2CA4');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939881E691FC');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939864E6496B');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993981645DEA9');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE parcel_job');
        $this->addSql('DROP TABLE reference_order');
        $this->addSql('DROP INDEX UNIQ_F52993983DBA2CA4 ON `order`');
        $this->addSql('DROP INDEX UNIQ_F529939881E691FC ON `order`');
        $this->addSql('DROP INDEX UNIQ_F52993981645DEA9 ON `order`');
        $this->addSql('DROP INDEX UNIQ_F529939864E6496B ON `order`');
        $this->addSql('ALTER TABLE `order` ADD graph_qlquery LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP to_recipient_id, DROP from_expediter_id, DROP reference_id, DROP parcel_job_id, DROP rest_api_query, DROP graphql_api_query, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `user` CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
