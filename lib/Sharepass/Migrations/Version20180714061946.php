<?php

namespace Royl\Sharepass\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180714061946 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("CREATE TABLE `linkdata` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `key` char(13) NOT NULL DEFAULT '',
              `data` text,
              `created` DATETIME NOT NULL DEFAULT '2018-01-01 00:00:00',
              `expires` DATETIME NOT NULL DEFAULT '2018-01-01 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE `linkedata`');
    }
}
