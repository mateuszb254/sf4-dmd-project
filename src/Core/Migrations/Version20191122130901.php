<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191122130901 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, author INT NOT NULL, title VARCHAR(50) NOT NULL, contents TEXT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_23A0E66BDAFD8C8 (author), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, account_id INT DEFAULT NULL, name VARCHAR(30) NOT NULL, level VARCHAR(30) DEFAULT \'1\' NOT NULL, ht INT DEFAULT 0 NOT NULL, dx INT DEFAULT 0 NOT NULL, st INT DEFAULT 0 NOT NULL, iq INT DEFAULT 0 NOT NULL, job INT DEFAULT 0 NOT NULL, alignment INT DEFAULT 0 NOT NULL, playtime INT DEFAULT 0 NOT NULL, horse_level INT DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_98197A655E237E06 (name), INDEX IDX_98197A659B6B5FBA (account_id), INDEX search (level), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_index (id INT NOT NULL, pid1 INT DEFAULT 0 NOT NULL, pid2 INT DEFAULT 0 NOT NULL, pid3 INT DEFAULT 0 NOT NULL, pid4 INT DEFAULT 0 NOT NULL, pid5 INT DEFAULT 0 NOT NULL, empire INT DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gmlist (character_id INT DEFAULT NULL, mId INT AUTO_INCREMENT NOT NULL, mAuthority VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A01D0AB91136BE75 (character_id), PRIMARY KEY(mId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE download (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(10) NOT NULL, uri VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guild (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, level VARCHAR(30) DEFAULT \'1\' NOT NULL, win VARCHAR(30) DEFAULT \'0\' NOT NULL, draw VARCHAR(30) DEFAULT \'0\' NOT NULL, loss VARCHAR(30) DEFAULT \'0\' NOT NULL, ladder_point INT NOT NULL, UNIQUE INDEX UNIQ_75407DAB5E237E06 (name), INDEX search (ladder_point), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guild_member (pid INT NOT NULL, guild_id INT NOT NULL, grade INT NOT NULL, INDEX IDX_7FD58C975F2131EF (guild_id), PRIMARY KEY(pid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_log (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, ip VARCHAR(255) NOT NULL, user_agent LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT NULL, dtype VARCHAR(255) NOT NULL, old_data VARCHAR(255) DEFAULT NULL, new_data VARCHAR(255) DEFAULT NULL, INDEX IDX_6429094EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(15) NOT NULL, expires DATETIME DEFAULT NULL, type VARCHAR(255) NOT NULL, coins INT NOT NULL, UNIQUE INDEX UNIQ_C11D7DD15E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion_coupon (id INT AUTO_INCREMENT NOT NULL, promotion_id INT DEFAULT NULL, generated_by INT NOT NULL, used_by INT DEFAULT NULL, code VARCHAR(8) NOT NULL, generated_at DATETIME NOT NULL, used_at DATETIME DEFAULT NULL, INDEX IDX_7105143F139DF194 (promotion_id), INDEX IDX_7105143F70252688 (generated_by), INDEX IDX_7105143F52EE6EC4 (used_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, author_id INT NOT NULL, title VARCHAR(50) NOT NULL, status VARCHAR(255) DEFAULT \'PENDING\' NOT NULL, content TEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_97A0ADA312469DE2 (category_id), INDEX IDX_97A0ADA3F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, slug VARCHAR(50) NOT NULL, priority INT DEFAULT NULL, fa_icon_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8325E5405E237E06 (name), UNIQUE INDEX UNIQ_8325E540989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_reply (id INT AUTO_INCREMENT NOT NULL, ticket_id INT NOT NULL, author_id INT NOT NULL, content TEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_D598A56B700047D2 (ticket_id), INDEX IDX_D598A56BF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE terms (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX idx_created_at (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, permissions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_9A1CACEA5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_group_id INT DEFAULT NULL, login VARCHAR(30) NOT NULL, email VARCHAR(64) NOT NULL, password VARCHAR(41) NOT NULL, is_global VARCHAR(255) DEFAULT \'\', char_removal_code VARCHAR(10) NOT NULL, status VARCHAR(255) DEFAULT \'OK\' NOT NULL, availDt DATETIME DEFAULT NULL, ban_reason VARCHAR(255) DEFAULT NULL, coins INT DEFAULT 0 NOT NULL, security_question VARCHAR(255) DEFAULT NULL, security_answer VARCHAR(255) DEFAULT NULL, email_change_token VARCHAR(25) DEFAULT NULL, email_change_token_created_at DATETIME DEFAULT NULL, password_reset_token VARCHAR(25) DEFAULT NULL, password_reset_token_created_at DATETIME DEFAULT NULL, money_drop_rate_expire DATETIME DEFAULT NULL, silver_expire DATETIME DEFAULT NULL, gold_expire DATETIME DEFAULT NULL, last_play DATETIME DEFAULT NULL, last_activity DATETIME DEFAULT NULL, last_ip VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), INDEX IDX_8D93D649D4873F76 (role_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66BDAFD8C8 FOREIGN KEY (author) REFERENCES user (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A659B6B5FBA FOREIGN KEY (account_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE player_index ADD CONSTRAINT FK_3F011C47BF396750 FOREIGN KEY (id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE gmlist ADD CONSTRAINT FK_A01D0AB91136BE75 FOREIGN KEY (character_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE guild_member ADD CONSTRAINT FK_7FD58C975550C4ED FOREIGN KEY (pid) REFERENCES player (id)');
        $this->addSql('ALTER TABLE guild_member ADD CONSTRAINT FK_7FD58C975F2131EF FOREIGN KEY (guild_id) REFERENCES guild (id)');
        $this->addSql('ALTER TABLE user_log ADD CONSTRAINT FK_6429094EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE promotion_coupon ADD CONSTRAINT FK_7105143F139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion_coupon ADD CONSTRAINT FK_7105143F70252688 FOREIGN KEY (generated_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE promotion_coupon ADD CONSTRAINT FK_7105143F52EE6EC4 FOREIGN KEY (used_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA312469DE2 FOREIGN KEY (category_id) REFERENCES ticket_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket_reply ADD CONSTRAINT FK_D598A56B700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket_reply ADD CONSTRAINT FK_D598A56BF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D4873F76 FOREIGN KEY (role_group_id) REFERENCES role_group (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gmlist DROP FOREIGN KEY FK_A01D0AB91136BE75');
        $this->addSql('ALTER TABLE guild_member DROP FOREIGN KEY FK_7FD58C975550C4ED');
        $this->addSql('ALTER TABLE guild_member DROP FOREIGN KEY FK_7FD58C975F2131EF');
        $this->addSql('ALTER TABLE promotion_coupon DROP FOREIGN KEY FK_7105143F139DF194');
        $this->addSql('ALTER TABLE ticket_reply DROP FOREIGN KEY FK_D598A56B700047D2');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA312469DE2');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D4873F76');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66BDAFD8C8');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A659B6B5FBA');
        $this->addSql('ALTER TABLE player_index DROP FOREIGN KEY FK_3F011C47BF396750');
        $this->addSql('ALTER TABLE user_log DROP FOREIGN KEY FK_6429094EA76ED395');
        $this->addSql('ALTER TABLE promotion_coupon DROP FOREIGN KEY FK_7105143F70252688');
        $this->addSql('ALTER TABLE promotion_coupon DROP FOREIGN KEY FK_7105143F52EE6EC4');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3F675F31B');
        $this->addSql('ALTER TABLE ticket_reply DROP FOREIGN KEY FK_D598A56BF675F31B');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE player_index');
        $this->addSql('DROP TABLE gmlist');
        $this->addSql('DROP TABLE download');
        $this->addSql('DROP TABLE guild');
        $this->addSql('DROP TABLE guild_member');
        $this->addSql('DROP TABLE user_log');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE promotion_coupon');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE ticket_category');
        $this->addSql('DROP TABLE ticket_reply');
        $this->addSql('DROP TABLE terms');
        $this->addSql('DROP TABLE role_group');
        $this->addSql('DROP TABLE user');
    }
}
