<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Enum\CategoryType;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220190049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $categories = [
            ['name' => 'revenus', 'type' => 'revenue'],
            ['name' => 'habitation', 'type' => 'expense'],
            ['name' => 'alimentation', 'type' => 'expense'],
            ['name' => 'habillement', 'type' => 'expense'],
            ['name' => 'santé', 'type' => 'expense'],
            ['name' => 'impots & assurances', 'type' => 'expense'],
            ['name' => 'éducation', 'type' => 'expense'],
            ['name' => 'transport', 'type' => 'expense'],
            ['name' => 'informatique & communication', 'type' => 'expense'],
            ['name' => 'loisirs & autre', 'type' => 'expense'],
            ['name' => 'épargne', 'type' => 'saving'],
        ];

        foreach($categories as $category) {
            // $this->addSql('INSERT INTO `category` (`name`, `type`) VALUES (:name, :type)', $category);
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE `category`');
    }
}
