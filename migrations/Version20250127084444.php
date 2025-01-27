<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250127084444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_global_permission (id INT AUTO_INCREMENT NOT NULL, admin_id INT DEFAULT NULL, role_id INT DEFAULT NULL, INDEX IDX_D1C54F89642B8210 (admin_id), INDEX IDX_D1C54F89D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, scope VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_unit_permission (id INT AUTO_INCREMENT NOT NULL, admin_id INT DEFAULT NULL, role_id INT DEFAULT NULL, unit_id INT DEFAULT NULL, INDEX IDX_DF31E88D642B8210 (admin_id), INDEX IDX_DF31E88DD60322AC (role_id), INDEX IDX_DF31E88DF8BD700D (unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE api_token (id INT AUTO_INCREMENT NOT NULL, owned_by_id INT NOT NULL, expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', token VARCHAR(68) NOT NULL, valid TINYINT(1) NOT NULL, INDEX IDX_7BA2F5EB5E70BCD7 (owned_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blood_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7C46DDF38CDE5729 (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE education_level (id INT AUTO_INCREMENT NOT NULL, level VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2666D6B49AEACC13 (level), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE individual (id INT AUTO_INCREMENT NOT NULL, military_rank_id INT NOT NULL, military_sub_rank_id INT NOT NULL, status_id INT NOT NULL, task_id INT NOT NULL, social_status_id INT NOT NULL, blood_type_id INT NOT NULL, religion_id INT NOT NULL, education_level_id INT NOT NULL, unit_id INT NOT NULL, name VARCHAR(255) NOT NULL, military_id VARCHAR(255) NOT NULL, register_date DATE NOT NULL, release_date DATE NOT NULL, birthdate DATE NOT NULL, national_id VARCHAR(255) NOT NULL, place_of_birth VARCHAR(255) NOT NULL, join_date DATE NOT NULL, specialization VARCHAR(255) NOT NULL, mobile_number VARCHAR(255) NOT NULL, profession VARCHAR(255) NOT NULL, address LONGTEXT NOT NULL, is_father_alive TINYINT(1) NOT NULL, is_mother_alive TINYINT(1) NOT NULL, detention_times INT NOT NULL, imprisonment_times INT NOT NULL, image LONGBLOB NOT NULL, INDEX IDX_8793FC17B8649276 (military_rank_id), INDEX IDX_8793FC17207A27AE (military_sub_rank_id), INDEX IDX_8793FC176BF700BD (status_id), INDEX IDX_8793FC178DB60186 (task_id), INDEX IDX_8793FC1759A15DCA (social_status_id), INDEX IDX_8793FC177AEA5732 (blood_type_id), INDEX IDX_8793FC17B7850CBD (religion_id), INDEX IDX_8793FC17D7A5352E (education_level_id), INDEX IDX_8793FC17F8BD700D (unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE individual_leave_reason (id INT AUTO_INCREMENT NOT NULL, reason VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_9BFAF2303BB8880C (reason), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE individual_status (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A4322AFF7B00651C (status), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE individual_task (id INT AUTO_INCREMENT NOT NULL, task VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_9ABC4196527EDB25 (task), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE individual_temporary_deployment (id INT AUTO_INCREMENT NOT NULL, individual_id INT DEFAULT NULL, deployment_date DATE NOT NULL, return_date DATE DEFAULT NULL, notice LONGTEXT DEFAULT NULL, destination_unit VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_AE99C995AE271C0D (individual_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE individual_temporary_guest (id INT AUTO_INCREMENT NOT NULL, individual_id INT DEFAULT NULL, arrival_date DATE NOT NULL, departure_date DATE DEFAULT NULL, notice LONGTEXT DEFAULT NULL, origin_unit VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6BCA67F5AE271C0D (individual_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE individual_vacation (id INT AUTO_INCREMENT NOT NULL, reason_id INT NOT NULL, individual_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, INDEX IDX_70EAFC6959BB1592 (reason_id), INDEX IDX_70EAFC69AE271C0D (individual_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE military_rank (id INT AUTO_INCREMENT NOT NULL, rank VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_71C6416A8879E8E5 (rank), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE military_sub_rank (id INT AUTO_INCREMENT NOT NULL, military_rank_id INT DEFAULT NULL, sub_rank VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6B404F69AFEF7724 (sub_rank), INDEX IDX_6B404F69B8649276 (military_rank_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE religion (id INT AUTO_INCREMENT NOT NULL, religion VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1055F4F91055F4F9 (religion), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_status (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_654B07C07B00651C (status), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, leader_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_DCBB0C535E237E06 (name), INDEX IDX_DCBB0C5373154ED4 (leader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin_global_permission ADD CONSTRAINT FK_D1C54F89642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE admin_global_permission ADD CONSTRAINT FK_D1C54F89D60322AC FOREIGN KEY (role_id) REFERENCES admin_role (id)');
        $this->addSql('ALTER TABLE admin_unit_permission ADD CONSTRAINT FK_DF31E88D642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE admin_unit_permission ADD CONSTRAINT FK_DF31E88DD60322AC FOREIGN KEY (role_id) REFERENCES admin_role (id)');
        $this->addSql('ALTER TABLE admin_unit_permission ADD CONSTRAINT FK_DF31E88DF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE api_token ADD CONSTRAINT FK_7BA2F5EB5E70BCD7 FOREIGN KEY (owned_by_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE individual ADD CONSTRAINT FK_8793FC17B8649276 FOREIGN KEY (military_rank_id) REFERENCES military_rank (id)');
        $this->addSql('ALTER TABLE individual ADD CONSTRAINT FK_8793FC17207A27AE FOREIGN KEY (military_sub_rank_id) REFERENCES military_sub_rank (id)');
        $this->addSql('ALTER TABLE individual ADD CONSTRAINT FK_8793FC176BF700BD FOREIGN KEY (status_id) REFERENCES individual_status (id)');
        $this->addSql('ALTER TABLE individual ADD CONSTRAINT FK_8793FC178DB60186 FOREIGN KEY (task_id) REFERENCES individual_task (id)');
        $this->addSql('ALTER TABLE individual ADD CONSTRAINT FK_8793FC1759A15DCA FOREIGN KEY (social_status_id) REFERENCES social_status (id)');
        $this->addSql('ALTER TABLE individual ADD CONSTRAINT FK_8793FC177AEA5732 FOREIGN KEY (blood_type_id) REFERENCES blood_type (id)');
        $this->addSql('ALTER TABLE individual ADD CONSTRAINT FK_8793FC17B7850CBD FOREIGN KEY (religion_id) REFERENCES religion (id)');
        $this->addSql('ALTER TABLE individual ADD CONSTRAINT FK_8793FC17D7A5352E FOREIGN KEY (education_level_id) REFERENCES education_level (id)');
        $this->addSql('ALTER TABLE individual ADD CONSTRAINT FK_8793FC17F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE individual_temporary_deployment ADD CONSTRAINT FK_AE99C995AE271C0D FOREIGN KEY (individual_id) REFERENCES individual (id)');
        $this->addSql('ALTER TABLE individual_temporary_guest ADD CONSTRAINT FK_6BCA67F5AE271C0D FOREIGN KEY (individual_id) REFERENCES individual (id)');
        $this->addSql('ALTER TABLE individual_vacation ADD CONSTRAINT FK_70EAFC6959BB1592 FOREIGN KEY (reason_id) REFERENCES individual_leave_reason (id)');
        $this->addSql('ALTER TABLE individual_vacation ADD CONSTRAINT FK_70EAFC69AE271C0D FOREIGN KEY (individual_id) REFERENCES individual (id)');
        $this->addSql('ALTER TABLE military_sub_rank ADD CONSTRAINT FK_6B404F69B8649276 FOREIGN KEY (military_rank_id) REFERENCES military_rank (id)');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C5373154ED4 FOREIGN KEY (leader_id) REFERENCES individual (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_global_permission DROP FOREIGN KEY FK_D1C54F89642B8210');
        $this->addSql('ALTER TABLE admin_global_permission DROP FOREIGN KEY FK_D1C54F89D60322AC');
        $this->addSql('ALTER TABLE admin_unit_permission DROP FOREIGN KEY FK_DF31E88D642B8210');
        $this->addSql('ALTER TABLE admin_unit_permission DROP FOREIGN KEY FK_DF31E88DD60322AC');
        $this->addSql('ALTER TABLE admin_unit_permission DROP FOREIGN KEY FK_DF31E88DF8BD700D');
        $this->addSql('ALTER TABLE api_token DROP FOREIGN KEY FK_7BA2F5EB5E70BCD7');
        $this->addSql('ALTER TABLE individual DROP FOREIGN KEY FK_8793FC17B8649276');
        $this->addSql('ALTER TABLE individual DROP FOREIGN KEY FK_8793FC17207A27AE');
        $this->addSql('ALTER TABLE individual DROP FOREIGN KEY FK_8793FC176BF700BD');
        $this->addSql('ALTER TABLE individual DROP FOREIGN KEY FK_8793FC178DB60186');
        $this->addSql('ALTER TABLE individual DROP FOREIGN KEY FK_8793FC1759A15DCA');
        $this->addSql('ALTER TABLE individual DROP FOREIGN KEY FK_8793FC177AEA5732');
        $this->addSql('ALTER TABLE individual DROP FOREIGN KEY FK_8793FC17B7850CBD');
        $this->addSql('ALTER TABLE individual DROP FOREIGN KEY FK_8793FC17D7A5352E');
        $this->addSql('ALTER TABLE individual DROP FOREIGN KEY FK_8793FC17F8BD700D');
        $this->addSql('ALTER TABLE individual_temporary_deployment DROP FOREIGN KEY FK_AE99C995AE271C0D');
        $this->addSql('ALTER TABLE individual_temporary_guest DROP FOREIGN KEY FK_6BCA67F5AE271C0D');
        $this->addSql('ALTER TABLE individual_vacation DROP FOREIGN KEY FK_70EAFC6959BB1592');
        $this->addSql('ALTER TABLE individual_vacation DROP FOREIGN KEY FK_70EAFC69AE271C0D');
        $this->addSql('ALTER TABLE military_sub_rank DROP FOREIGN KEY FK_6B404F69B8649276');
        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C5373154ED4');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE admin_global_permission');
        $this->addSql('DROP TABLE admin_role');
        $this->addSql('DROP TABLE admin_unit_permission');
        $this->addSql('DROP TABLE api_token');
        $this->addSql('DROP TABLE blood_type');
        $this->addSql('DROP TABLE education_level');
        $this->addSql('DROP TABLE individual');
        $this->addSql('DROP TABLE individual_leave_reason');
        $this->addSql('DROP TABLE individual_status');
        $this->addSql('DROP TABLE individual_task');
        $this->addSql('DROP TABLE individual_temporary_deployment');
        $this->addSql('DROP TABLE individual_temporary_guest');
        $this->addSql('DROP TABLE individual_vacation');
        $this->addSql('DROP TABLE military_rank');
        $this->addSql('DROP TABLE military_sub_rank');
        $this->addSql('DROP TABLE religion');
        $this->addSql('DROP TABLE social_status');
        $this->addSql('DROP TABLE unit');
    }
}
