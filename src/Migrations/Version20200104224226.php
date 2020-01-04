<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200104224226 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE eleves (matter_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_383B09B1D614E59F (matter_id), INDEX IDX_383B09B1A76ED395 (user_id), PRIMARY KEY(matter_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_user (id INT AUTO_INCREMENT NOT NULL, student_matter_id INT NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_B2B0AD91B17A241F (student_matter_id), INDEX IDX_B2B0AD91A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B1D614E59F FOREIGN KEY (matter_id) REFERENCES matter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_user ADD CONSTRAINT FK_B2B0AD91B17A241F FOREIGN KEY (student_matter_id) REFERENCES matter (id)');
        $this->addSql('ALTER TABLE student_user ADD CONSTRAINT FK_B2B0AD91A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE user_matter');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, matiere_id INT NOT NULL, issou_id INT DEFAULT NULL, INDEX IDX_ECA105F724337D30 (issou_id), INDEX IDX_ECA105F7F46CD258 (matiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_matter (user_id INT NOT NULL, matter_id INT NOT NULL, INDEX IDX_D58C8052A76ED395 (user_id), INDEX IDX_D58C8052D614E59F (matter_id), PRIMARY KEY(user_id, matter_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F724337D30 FOREIGN KEY (issou_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7F46CD258 FOREIGN KEY (matiere_id) REFERENCES matter (id)');
        $this->addSql('ALTER TABLE user_matter ADD CONSTRAINT FK_D58C8052A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_matter ADD CONSTRAINT FK_D58C8052D614E59F FOREIGN KEY (matter_id) REFERENCES matter (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE eleves');
        $this->addSql('DROP TABLE student_user');
    }
}
