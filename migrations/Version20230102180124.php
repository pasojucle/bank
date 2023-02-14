<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230102180124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $clusters = [
            ['name' => 'revenus', 'position' => 1],
            ['name' => 'habitation', 'position' => 2],
            ['name' => 'alimentation', 'position' => 3],
            ['name' => 'habillement', 'position' => 4],
            ['name' => 'santé', 'position' => 5],
            ['name' => 'impots & assurances', 'position' => 6],
            ['name' => 'éducation', 'position' => 7],
            ['name' => 'transport', 'position' => 8],
            ['name' => 'informatique & communication', 'position' => 9],
            ['name' => 'loisirs & autre', 'position' => 10],
            ['name' => 'épargne', 'position' => 11],
        ];

        foreach($clusters as $cluster) {
            $cluster['id'] = $cluster['position'];
            $this->addSql('INSERT INTO `cluster` (`id`, `name`, `position`) VALUES (:id, :name, :position)', $cluster);
        }

        $categories = [
            ['name' => 'loyer', 'cluster' => 2],
            ['name' => 'caf', 'cluster' => 1],
            ['name' => 'éléctricité', 'cluster' => 2],
            ['name' => 'gaz', 'cluster' => 2],
            ['name' => 'assurances', 'cluster' => 6],
            ['name' => 'eau', 'cluster' => 2],
            ['name' => 'docteur', 'cluster' => 5],
            ['name' => 'pharmacie', 'cluster' => 5],
            ['name' => 'impots fonciers', 'cluster' => 6],
            ['name' => 'impots locaux', 'cluster' => 6],
            ['name' => 'impots sur le revenu', 'cluster' => 6],
            ['name' => 'essence', 'cluster' => 8],
            ['name' => 'entretient voiture', 'cluster' => 8],
            ['name' => 'train', 'cluster' => 8],
            ['name' => 'salaire', 'cluster' => 1],
            ['name' => 'bourses', 'cluster' => 1],
        ];

        foreach($categories as $category) {
            $this->addSql('INSERT INTO `category` (`name`, `cluster_id`) VALUES (:name, :cluster)', $category);
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE `cluster`');
    }
}
