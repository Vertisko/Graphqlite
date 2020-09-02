<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200902181810 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE person (id UUID NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, external_id VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34DCD1769F75D7B0 ON person (external_id)');
        $this->addSql('COMMENT ON COLUMN person.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN person.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE genre (id UUID NOT NULL, image_url VARCHAR(100) NOT NULL, name VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, external_id VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_835033F89F75D7B0 ON genre (external_id)');
        $this->addSql('COMMENT ON COLUMN genre.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN genre.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE event_tag (id UUID NOT NULL, name VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN event_tag.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN event_tag.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE event (id UUID NOT NULL, title VARCHAR(100) NOT NULL, original_title VARCHAR(100) DEFAULT NULL, poster_url VARCHAR(255) DEFAULT NULL, year INT DEFAULT NULL, number INT DEFAULT NULL, synopsis TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, external_id VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BAE0AA79F75D7B0 ON event (external_id)');
        $this->addSql('COMMENT ON COLUMN event.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN event.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE event_actors (event_id UUID NOT NULL, person_id UUID NOT NULL, PRIMARY KEY(event_id, person_id))');
        $this->addSql('CREATE INDEX IDX_EDB287B771F7E88B ON event_actors (event_id)');
        $this->addSql('CREATE INDEX IDX_EDB287B7217BBB47 ON event_actors (person_id)');
        $this->addSql('CREATE TABLE event_directors (event_id UUID NOT NULL, person_id UUID NOT NULL, PRIMARY KEY(event_id, person_id))');
        $this->addSql('CREATE INDEX IDX_203893F971F7E88B ON event_directors (event_id)');
        $this->addSql('CREATE INDEX IDX_203893F9217BBB47 ON event_directors (person_id)');
        $this->addSql('CREATE TABLE event_genre (event_id UUID NOT NULL, genre_id UUID NOT NULL, PRIMARY KEY(event_id, genre_id))');
        $this->addSql('CREATE INDEX IDX_C24B82D471F7E88B ON event_genre (event_id)');
        $this->addSql('CREATE INDEX IDX_C24B82D44296D31F ON event_genre (genre_id)');
        $this->addSql('CREATE TABLE channel_group (id UUID NOT NULL, name VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN channel_group.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN channel_group.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE channel (id UUID NOT NULL, channel_group_id UUID DEFAULT NULL, activated BOOLEAN DEFAULT \'true\' NOT NULL, name VARCHAR(100) NOT NULL, external_name VARCHAR(100) DEFAULT NULL, description TEXT DEFAULT NULL, logo_url VARCHAR(255) DEFAULT NULL, parental_rating INT DEFAULT NULL, time_shift_sliding_window INT NOT NULL, dc_api_id VARCHAR(20) DEFAULT NULL, last_update TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, last_synchronization TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, external_id VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A2F98E479F75D7B0 ON channel (external_id)');
        $this->addSql('CREATE INDEX IDX_A2F98E4789E4AAEE ON channel (channel_group_id)');
        $this->addSql('COMMENT ON COLUMN channel.last_update IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN channel.last_synchronization IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN channel.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN channel.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE epg_event (id UUID NOT NULL, channel_id UUID NOT NULL, event_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, start TIMESTAMP(0) WITH TIME ZONE NOT NULL, "end" TIMESTAMP(0) WITH TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_12E8742672F5A1AA ON epg_event (channel_id)');
        $this->addSql('CREATE INDEX IDX_12E8742671F7E88B ON epg_event (event_id)');
        $this->addSql('COMMENT ON COLUMN epg_event.start IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN epg_event."end" IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN epg_event.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN epg_event.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE epg_event_event_tag (epg_event_id UUID NOT NULL, event_tag_id UUID NOT NULL, PRIMARY KEY(epg_event_id, event_tag_id))');
        $this->addSql('CREATE INDEX IDX_10A28130BF0329C8 ON epg_event_event_tag (epg_event_id)');
        $this->addSql('CREATE INDEX IDX_10A28130884B1443 ON epg_event_event_tag (event_tag_id)');
        $this->addSql('ALTER TABLE event_actors ADD CONSTRAINT FK_EDB287B771F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_actors ADD CONSTRAINT FK_EDB287B7217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_directors ADD CONSTRAINT FK_203893F971F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_directors ADD CONSTRAINT FK_203893F9217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_genre ADD CONSTRAINT FK_C24B82D471F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_genre ADD CONSTRAINT FK_C24B82D44296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E4789E4AAEE FOREIGN KEY (channel_group_id) REFERENCES channel_group (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE epg_event ADD CONSTRAINT FK_12E8742672F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE epg_event ADD CONSTRAINT FK_12E8742671F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE epg_event_event_tag ADD CONSTRAINT FK_10A28130BF0329C8 FOREIGN KEY (epg_event_id) REFERENCES epg_event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE epg_event_event_tag ADD CONSTRAINT FK_10A28130884B1443 FOREIGN KEY (event_tag_id) REFERENCES event_tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE epg_event DROP CONSTRAINT FK_12E8742672F5A1AA');
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT FK_A2F98E4789E4AAEE');
        $this->addSql('ALTER TABLE epg_event_event_tag DROP CONSTRAINT FK_10A28130BF0329C8');
        $this->addSql('ALTER TABLE epg_event DROP CONSTRAINT FK_12E8742671F7E88B');
        $this->addSql('ALTER TABLE event_genre DROP CONSTRAINT FK_C24B82D471F7E88B');
        $this->addSql('ALTER TABLE event_directors DROP CONSTRAINT FK_203893F971F7E88B');
        $this->addSql('ALTER TABLE event_actors DROP CONSTRAINT FK_EDB287B771F7E88B');
        $this->addSql('ALTER TABLE epg_event_event_tag DROP CONSTRAINT FK_10A28130884B1443');
        $this->addSql('ALTER TABLE event_genre DROP CONSTRAINT FK_C24B82D44296D31F');
        $this->addSql('ALTER TABLE event_directors DROP CONSTRAINT FK_203893F9217BBB47');
        $this->addSql('ALTER TABLE event_actors DROP CONSTRAINT FK_EDB287B7217BBB47');
        $this->addSql('DROP TABLE channel');
        $this->addSql('DROP TABLE channel_group');
        $this->addSql('DROP TABLE epg_event');
        $this->addSql('DROP TABLE epg_event_event_tag');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_genre');
        $this->addSql('DROP TABLE event_directors');
        $this->addSql('DROP TABLE event_actors');
        $this->addSql('DROP TABLE event_tag');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE person');
    }
}
