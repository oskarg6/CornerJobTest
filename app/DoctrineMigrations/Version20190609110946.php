<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190609110946 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE api_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_AC64A0BAF85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coffee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, intensity INT NOT NULL, price DOUBLE PRECISION NOT NULL, stock INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coffee_order (id INT AUTO_INCREMENT NOT NULL, api_user_id INT DEFAULT NULL, coffee_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, INDEX IDX_9BE3854A4A50A7F2 (api_user_id), INDEX IDX_9BE3854A78CD6D6E (coffee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coffee_order ADD CONSTRAINT FK_9BE3854A4A50A7F2 FOREIGN KEY (api_user_id) REFERENCES api_user (id)');
        $this->addSql('ALTER TABLE coffee_order ADD CONSTRAINT FK_9BE3854A78CD6D6E FOREIGN KEY (coffee_id) REFERENCES coffee (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE coffee_order DROP FOREIGN KEY FK_9BE3854A4A50A7F2');
        $this->addSql('ALTER TABLE coffee_order DROP FOREIGN KEY FK_9BE3854A78CD6D6E');
        $this->addSql('DROP TABLE api_user');
        $this->addSql('DROP TABLE coffee');
        $this->addSql('DROP TABLE coffee_order');
    }
}
