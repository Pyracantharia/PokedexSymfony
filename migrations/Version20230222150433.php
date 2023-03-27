<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230222150433 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_pokemon (user_id INT NOT NULL, pokemon_id INT NOT NULL, INDEX IDX_3AD18EF9A76ED395 (user_id), INDEX IDX_3AD18EF92FE71C3E (pokemon_id), PRIMARY KEY(user_id, pokemon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_pokemon ADD CONSTRAINT FK_3AD18EF9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_pokemon ADD CONSTRAINT FK_3AD18EF92FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F38EB23357');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F38EB23357 FOREIGN KEY (types_id) REFERENCES types (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_pokemon');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F38EB23357');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F38EB23357 FOREIGN KEY (types_id) REFERENCES types (id) ON DELETE CASCADE');
    }
}
