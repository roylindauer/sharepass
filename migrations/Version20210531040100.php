<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210531040100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE `secrets` (
              `id` INT unsigned NOT NULL AUTO_INCREMENT,
              `access_key` char(13) NOT NULL DEFAULT '',
              `secret_data` text,
              `created` DATETIME NOT NULL DEFAULT '2018-01-01 00:00:00',
              `expires` DATETIME NOT NULL DEFAULT '2018-01-01 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE secrets');
    }
}
