CREATE TABLE country (id BIGINT AUTO_INCREMENT, code CHAR(3) NOT NULL, name VARCHAR(60) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE environment (id BIGINT AUTO_INCREMENT, name VARCHAR(127) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE habitat (id BIGINT AUTO_INCREMENT, name VARCHAR(127) NOT NULL, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE island (id BIGINT AUTO_INCREMENT, code CHAR(2) NOT NULL, name VARCHAR(60) NOT NULL, region_id BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE location (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL, latitude CHAR(10), longitude CHAR(10), country_id BIGINT NOT NULL, region_id BIGINT NOT NULL, island_id BIGINT NOT NULL, remarks TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX country_id_idx (country_id), INDEX region_id_idx (region_id), INDEX island_id_idx (island_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE location_picture (id BIGINT AUTO_INCREMENT, filename VARCHAR(255) NOT NULL, location_id BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX location_id_idx (location_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE radiation (id BIGINT AUTO_INCREMENT, name VARCHAR(127) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE region (id BIGINT AUTO_INCREMENT, code CHAR(2) NOT NULL, name VARCHAR(60) NOT NULL, country_id BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sample (id BIGINT AUTO_INCREMENT, location_id BIGINT NOT NULL, latitude CHAR(10), longitude CHAR(10), environment_id BIGINT NOT NULL, habitat_id BIGINT NOT NULL, ph FLOAT(18, 2), conductivity FLOAT(18, 2), temperature FLOAT(18, 2), salinity FLOAT(18, 2), altitude FLOAT(18, 2), radiation_id BIGINT NOT NULL, field_picture VARCHAR(255), detailed_picture VARCHAR(255), microscopic_picture VARCHAR(255), collector_id BIGINT NOT NULL, collection_date DATE NOT NULL, remarks TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX location_id_idx (location_id), INDEX environment_id_idx (environment_id), INDEX habitat_id_idx (habitat_id), INDEX radiation_id_idx (radiation_id), INDEX collector_id_idx (collector_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_forgot_password (id BIGINT AUTO_INCREMENT, user_id BIGINT NOT NULL, unique_key VARCHAR(255), expires_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group_permission (group_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(group_id, permission_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_permission (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_remember_key (id BIGINT AUTO_INCREMENT, user_id BIGINT, remember_key VARCHAR(32), ip_address VARCHAR(50), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user (id BIGINT AUTO_INCREMENT, first_name VARCHAR(255), last_name VARCHAR(255), email_address VARCHAR(255) NOT NULL UNIQUE, username VARCHAR(128) NOT NULL UNIQUE, algorithm VARCHAR(128) DEFAULT 'sha1' NOT NULL, salt VARCHAR(128), password VARCHAR(128), is_active TINYINT(1) DEFAULT '1', is_super_admin TINYINT(1) DEFAULT '0', last_login DATETIME, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX is_active_idx_idx (is_active), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_group (user_id BIGINT, group_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, group_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_permission (user_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, permission_id)) ENGINE = INNODB;
ALTER TABLE location ADD CONSTRAINT location_region_id_region_id FOREIGN KEY (region_id) REFERENCES region(id);
ALTER TABLE location ADD CONSTRAINT location_island_id_island_id FOREIGN KEY (island_id) REFERENCES island(id);
ALTER TABLE location ADD CONSTRAINT location_country_id_country_id FOREIGN KEY (country_id) REFERENCES country(id);
ALTER TABLE location_picture ADD CONSTRAINT location_picture_location_id_location_id FOREIGN KEY (location_id) REFERENCES location(id) ON DELETE CASCADE;
ALTER TABLE sample ADD CONSTRAINT sample_radiation_id_radiation_id FOREIGN KEY (radiation_id) REFERENCES radiation(id);
ALTER TABLE sample ADD CONSTRAINT sample_location_id_location_id FOREIGN KEY (location_id) REFERENCES location(id);
ALTER TABLE sample ADD CONSTRAINT sample_habitat_id_habitat_id FOREIGN KEY (habitat_id) REFERENCES habitat(id);
ALTER TABLE sample ADD CONSTRAINT sample_environment_id_environment_id FOREIGN KEY (environment_id) REFERENCES environment(id);
ALTER TABLE sample ADD CONSTRAINT sample_collector_id_sf_guard_user_id FOREIGN KEY (collector_id) REFERENCES sf_guard_user(id);
ALTER TABLE sf_guard_forgot_password ADD CONSTRAINT sf_guard_forgot_password_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_remember_key ADD CONSTRAINT sf_guard_remember_key_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
