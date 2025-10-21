<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251021205700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE anouncement (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, pictures LONGTEXT NOT NULL, categorie VARCHAR(255) NOT NULL, adress LONGTEXT NOT NULL, post_x DOUBLE PRECISION NOT NULL, post_y DOUBLE PRECISION NOT NULL, post_z DOUBLE PRECISION NOT NULL, status INT NOT NULL, create_at DATE NOT NULL, INDEX IDX_7DE47A3EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, anouncement_id INT DEFAULT NULL, contenue VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_9474526CA76ED395 (user_id), INDEX IDX_9474526C3A03BACA (anouncement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donation (id INT AUTO_INCREMENT NOT NULL, price DOUBLE PRECISION NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reporting (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, anouncement_id INT DEFAULT NULL, reason VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_BD7CFA9FA76ED395 (user_id), INDEX IDX_BD7CFA9F3A03BACA (anouncement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscribe (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, date DATE NOT NULL, status INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_donation (id INT AUTO_INCREMENT NOT NULL, donation_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_D16865A04DC1279C (donation_id), INDEX IDX_D16865A0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_subscribe (id INT AUTO_INCREMENT NOT NULL, soubcribe_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_6859D2DAF5BA179D (soubcribe_id), INDEX IDX_6859D2DAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, create_at DATE NOT NULL, credit INT NOT NULL, status INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE anouncement ADD CONSTRAINT FK_7DE47A3EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C3A03BACA FOREIGN KEY (anouncement_id) REFERENCES anouncement (id)');
        $this->addSql('ALTER TABLE reporting ADD CONSTRAINT FK_BD7CFA9FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reporting ADD CONSTRAINT FK_BD7CFA9F3A03BACA FOREIGN KEY (anouncement_id) REFERENCES anouncement (id)');
        $this->addSql('ALTER TABLE user_donation ADD CONSTRAINT FK_D16865A04DC1279C FOREIGN KEY (donation_id) REFERENCES donation (id)');
        $this->addSql('ALTER TABLE user_donation ADD CONSTRAINT FK_D16865A0A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_subscribe ADD CONSTRAINT FK_6859D2DAF5BA179D FOREIGN KEY (soubcribe_id) REFERENCES subscribe (id)');
        $this->addSql('ALTER TABLE user_subscribe ADD CONSTRAINT FK_6859D2DAA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE anouncement DROP FOREIGN KEY FK_7DE47A3EA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C3A03BACA');
        $this->addSql('ALTER TABLE reporting DROP FOREIGN KEY FK_BD7CFA9FA76ED395');
        $this->addSql('ALTER TABLE reporting DROP FOREIGN KEY FK_BD7CFA9F3A03BACA');
        $this->addSql('ALTER TABLE user_donation DROP FOREIGN KEY FK_D16865A04DC1279C');
        $this->addSql('ALTER TABLE user_donation DROP FOREIGN KEY FK_D16865A0A76ED395');
        $this->addSql('ALTER TABLE user_subscribe DROP FOREIGN KEY FK_6859D2DAF5BA179D');
        $this->addSql('ALTER TABLE user_subscribe DROP FOREIGN KEY FK_6859D2DAA76ED395');
        $this->addSql('DROP TABLE anouncement');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE donation');
        $this->addSql('DROP TABLE reporting');
        $this->addSql('DROP TABLE subscribe');
        $this->addSql('DROP TABLE user_donation');
        $this->addSql('DROP TABLE user_subscribe');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
