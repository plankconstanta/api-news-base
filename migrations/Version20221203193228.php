<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221203193228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE news_tag_news (news_id INT NOT NULL, tag_news_id INT NOT NULL, INDEX IDX_BAE285B7B5A459A0 (news_id), INDEX IDX_BAE285B78795740A (tag_news_id), PRIMARY KEY(news_id, tag_news_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE news_tag_news ADD CONSTRAINT FK_BAE285B7B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news_tag_news ADD CONSTRAINT FK_BAE285B78795740A FOREIGN KEY (tag_news_id) REFERENCES tag_news (id) ON DELETE CASCADE');
        //$this->addSql('DROP INDEX fk.tag_news ON tag_news');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE news_tag_news DROP FOREIGN KEY FK_BAE285B7B5A459A0');
        $this->addSql('ALTER TABLE news_tag_news DROP FOREIGN KEY FK_BAE285B78795740A');
        $this->addSql('DROP TABLE news_tag_news');
        //$this->addSql('CREATE INDEX fk.tag_news ON tag_news (hash)');
    }
}
