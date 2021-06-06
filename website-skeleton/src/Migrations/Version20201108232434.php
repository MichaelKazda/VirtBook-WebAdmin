<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201108232434 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE branch CHANGE address_id address_id INT DEFAULT NULL, CHANGE partner_id partner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE branch_contact CHANGE branch_id branch_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE branch_media CHANGE branch_id branch_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customer CHANGE address_id address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_bill CHANGE customer_id customer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_meta CHANGE order_bill_id order_bill_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL, CHANGE branch_id branch_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_sub_product CHANGE main_order_meta_id main_order_meta_id INT DEFAULT NULL, CHANGE sub_order_meta_id sub_order_meta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partner CHANGE address_id address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_commission CHANGE partner_id partner_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_files CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_relation CHANGE main_product_id main_product_id INT DEFAULT NULL, CHANGE sub_product_id sub_product_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE branch CHANGE address_id address_id INT NOT NULL, CHANGE partner_id partner_id INT NOT NULL');
        $this->addSql('ALTER TABLE branch_contact CHANGE branch_id branch_id INT NOT NULL');
        $this->addSql('ALTER TABLE branch_media CHANGE branch_id branch_id INT NOT NULL');
        $this->addSql('ALTER TABLE customer CHANGE address_id address_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_bill CHANGE customer_id customer_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_meta CHANGE branch_id branch_id INT NOT NULL, CHANGE order_bill_id order_bill_id INT NOT NULL, CHANGE product_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_sub_product CHANGE main_order_meta_id main_order_meta_id INT NOT NULL, CHANGE sub_order_meta_id sub_order_meta_id INT NOT NULL');
        $this->addSql('ALTER TABLE partner CHANGE address_id address_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_commission CHANGE partner_id partner_id INT NOT NULL, CHANGE product_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_files CHANGE product_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_relation CHANGE main_product_id main_product_id INT NOT NULL, CHANGE sub_product_id sub_product_id INT NOT NULL');
    }
}
