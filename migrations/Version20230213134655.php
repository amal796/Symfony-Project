<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213134655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande CHANGE id_panier id_panier INT DEFAULT NULL, CHANGE id_utilisateur id_utilisateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier CHANGE id_produit id_produit INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participation CHANGE id_user id_user INT DEFAULT NULL, CHANGE id_evenement id_evenement INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE id_utilisateur id_utilisateur INT DEFAULT NULL, CHANGE id_categorie id_categorie INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE id_terrain id_terrain INT DEFAULT NULL, CHANGE id_utilisateur id_utilisateur INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE commande CHANGE id_panier id_panier INT NOT NULL, CHANGE id_utilisateur id_utilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE panier CHANGE id_produit id_produit INT NOT NULL');
        $this->addSql('ALTER TABLE participation CHANGE id_evenement id_evenement INT NOT NULL, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE id_utilisateur id_utilisateur INT NOT NULL, CHANGE id_categorie id_categorie INT NOT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE id_utilisateur id_utilisateur INT NOT NULL, CHANGE id_terrain id_terrain INT NOT NULL');
    }
}
