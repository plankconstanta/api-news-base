<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\Uid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221203195905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO tag_news(`id`, `name`, `hash`) VALUES
            (1, "политика", '.crc32("политика") . '),
            (2, "экономика", '.crc32("экономика") . '),
            (3, "финансы", '.crc32("финансы") . '),
            (4, "спорт", '.crc32("спорт") . '),
            (5, "культура", '.crc32("культура").'),
            (6, "экология", '.crc32("экология").')
        ');

        $this->addSql('INSERT INTO news(`id`, `title`, `text`, `published_at`, `photo_uuid`) VALUES
            (1, "новость 1", "текст новости 1", "2022-01-20 12:00:00", "'.Uuid::v1()->toBase32().'"),
            (2, "новость 2", "текст новости 2", "2022-02-20 12:00:00", "'.Uuid::v1()->toBase32().'"),
            (3, "новость 3", "текст новости 3", "2022-03-20 12:00:00", "'.Uuid::v1()->toBase32().'"),
            (4, "новость 4", "текст новости 4", "2022-04-20 12:00:00", "'.Uuid::v1()->toBase32().'"),
            (5, "новость 5", "текст новости 5", "2022-05-20 12:00:00", "'.Uuid::v1()->toBase32().'"),
            (6, "новость 6", "текст новости 6", "2022-06-20 12:00:00", "'.Uuid::v1()->toBase32().'"),
            (7, "новость 7", "текст новости 7", "2022-07-20 12:00:00", "'.Uuid::v1()->toBase32().'")
        ');

        $this->addSql('INSERT INTO news_tag_news(`news_id`, `tag_news_id`) VALUES
            (1, 2),
            (1, 4), 
            (2, 3), 
            (3, 2),
            (3, 4),
            (3, 5),
            (4, 1),
            (4, 2),
            (6, 4),
            (7, 3),
            (7, 5)
        ');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM news');
        $this->addSql('DELETE FROM tag_news');
        $this->addSql('DELETE FROM news_tag_news');
    }
}
