<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317165338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE phone_number phone_number VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE address1 address1 VARCHAR(255) DEFAULT NULL, CHANGE country country VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` CHANGE service_type service_type VARCHAR(255) DEFAULT NULL, CHANGE service_level service_level VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE parcel_job CHANGE size size VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone_number phone_number VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address1 address1 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address2 address2 VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE postcode postcode VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `order` CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE rest_api_query rest_api_query LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE graphql_api_query graphql_api_query LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE service_type service_type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE service_level service_level VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE requested_tracking_number requested_tracking_number VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE parcel_job CHANGE pickup_service_type pickup_service_type VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pickup_service_level pickup_service_level VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE delivery_instructions delivery_instructions LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE size size VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reference_order CHANGE merchant_order_number merchant_order_number VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `user` CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
