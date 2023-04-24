<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220185954 extends AbstractMigration
{
    
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account_user (account_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_10051E39B6B5FBA (account_id), INDEX IDX_10051E3A76ED395 (user_id), PRIMARY KEY(account_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deadline (id INT AUTO_INCREMENT NOT NULL, label_id INT DEFAULT NULL, category_id INT DEFAULT NULL, debit_account_id INT DEFAULT NULL, credit_account_id INT DEFAULT NULL, day INT NOT NULL, end_at DATE DEFAULT NULL, amount INT NOT NULL, INDEX IDX_B74774F233B92F39 (label_id), INDEX IDX_B74774F212469DE2 (category_id), INDEX IDX_B74774F2204C4EAA (debit_account_id), INDEX IDX_B74774F26813E404 (credit_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deadline_month (deadline_id INT NOT NULL, month_id INT NOT NULL, INDEX IDX_96548A9673EA0AF8 (deadline_id), INDEX IDX_96548A96A0CBDE4 (month_id), PRIMARY KEY(deadline_id, month_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE label (id INT AUTO_INCREMENT NOT NULL, account_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_EA750E89B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE month (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, label_id INT DEFAULT NULL, category_id INT DEFAULT NULL, debit_account_id INT DEFAULT NULL, credit_account_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', checked TINYINT(1) NOT NULL, comment LONGTEXT DEFAULT NULL, amount INT NOT NULL, INDEX IDX_723705D133B92F39 (label_id), INDEX IDX_723705D112469DE2 (category_id), INDEX IDX_723705D1204C4EAA (debit_account_id), INDEX IDX_723705D16813E404 (credit_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, token VARCHAR(255) DEFAULT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(64) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account_user ADD CONSTRAINT FK_10051E39B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE account_user ADD CONSTRAINT FK_10051E3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE deadline ADD CONSTRAINT FK_B74774F233B92F39 FOREIGN KEY (label_id) REFERENCES label (id)');
        $this->addSql('ALTER TABLE deadline ADD CONSTRAINT FK_B74774F212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE deadline ADD CONSTRAINT FK_B74774F2204C4EAA FOREIGN KEY (debit_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE deadline ADD CONSTRAINT FK_B74774F26813E404 FOREIGN KEY (credit_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE deadline_month ADD CONSTRAINT FK_96548A9673EA0AF8 FOREIGN KEY (deadline_id) REFERENCES deadline (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE deadline_month ADD CONSTRAINT FK_96548A96A0CBDE4 FOREIGN KEY (month_id) REFERENCES month (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE label ADD CONSTRAINT FK_EA750E89B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D133B92F39 FOREIGN KEY (label_id) REFERENCES label (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1204C4EAA FOREIGN KEY (debit_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D16813E404 FOREIGN KEY (credit_account_id) REFERENCES account (id)');
    
        $monts = [
            ['id' => 1, 'name' => 'Janvier'],
            ['id' => 2, 'name' => 'Février'],
            ['id' => 3, 'name' => 'Mars'],
            ['id' => 4, 'name' => 'Avril'],
            ['id' => 5, 'name' => 'Mai'],
            ['id' => 6, 'name' => 'Juin'],
            ['id' => 7, 'name' => 'Juillet'],
            ['id' => 8, 'name' => 'Août'],
            ['id' => 9, 'name' => 'Septembre'],
            ['id' => 10, 'name' => 'Octobre'],
            ['id' => 11, 'name' => 'Novembre'],
            ['id' => 12, 'name' => 'Décembre'],
        ];
        foreach ($monts as $month) {
            $this->addSql('INSERT INTO `month` (`id`, `name`) VALUES (:id, :name)', $month);
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account_user DROP FOREIGN KEY FK_10051E39B6B5FBA');
        $this->addSql('ALTER TABLE account_user DROP FOREIGN KEY FK_10051E3A76ED395');
        $this->addSql('ALTER TABLE deadline DROP FOREIGN KEY FK_B74774F233B92F39');
        $this->addSql('ALTER TABLE deadline DROP FOREIGN KEY FK_B74774F212469DE2');
        $this->addSql('ALTER TABLE deadline DROP FOREIGN KEY FK_B74774F2204C4EAA');
        $this->addSql('ALTER TABLE deadline DROP FOREIGN KEY FK_B74774F26813E404');
        $this->addSql('ALTER TABLE deadline_month DROP FOREIGN KEY FK_96548A9673EA0AF8');
        $this->addSql('ALTER TABLE deadline_month DROP FOREIGN KEY FK_96548A96A0CBDE4');
        $this->addSql('ALTER TABLE label DROP FOREIGN KEY FK_EA750E89B6B5FBA');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D133B92F39');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D112469DE2');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1204C4EAA');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D16813E404');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE account_user');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE deadline');
        $this->addSql('DROP TABLE deadline_month');
        $this->addSql('DROP TABLE label');
        $this->addSql('DROP TABLE month');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
