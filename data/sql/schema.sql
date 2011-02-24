CREATE TABLE country (id BIGINT AUTO_INCREMENT, name VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE ecosystem (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL, latitude_degrees BIGINT, longitude_degrees BIGINT, latitude_minutes FLOAT(18, 2), longitude_minutes FLOAT(18, 2), country_id BIGINT NOT NULL, province_id BIGINT, city VARCHAR(255) NOT NULL, remarks TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX country_id_idx (country_id), INDEX province_id_idx (province_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE ecosystem_picture (id BIGINT AUTO_INCREMENT, filename VARCHAR(255) NOT NULL, ecosystem_id BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX ecosystem_id_idx (ecosystem_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE environment (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE habitat (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE province (id BIGINT AUTO_INCREMENT, name VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE role (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sample (id BIGINT AUTO_INCREMENT, ecosystem_id BIGINT NOT NULL, location VARCHAR(255) NOT NULL, latitude_degrees BIGINT, longitude_degrees BIGINT, latitude_minutes FLOAT(18, 2), longitude_minutes FLOAT(18, 2), environment_id BIGINT NOT NULL, habitat_id BIGINT NOT NULL, ph FLOAT(18, 2), conductivity FLOAT(18, 2), temperature FLOAT(18, 2), salinity FLOAT(18, 2), field_picture VARCHAR(255), detailed_picture VARCHAR(255), collector_id BIGINT NOT NULL, collection_date DATE NOT NULL, remarks TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX ecosystem_id_idx (ecosystem_id), INDEX environment_id_idx (environment_id), INDEX habitat_id_idx (habitat_id), INDEX collector_id_idx (collector_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE user (id BIGINT AUTO_INCREMENT, username VARCHAR(30) NOT NULL, password VARCHAR(30) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, role_id BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX role_id_idx (role_id), PRIMARY KEY(id)) ENGINE = INNODB;
ALTER TABLE ecosystem ADD CONSTRAINT ecosystem_province_id_province_id FOREIGN KEY (province_id) REFERENCES province(id);
ALTER TABLE ecosystem ADD CONSTRAINT ecosystem_country_id_country_id FOREIGN KEY (country_id) REFERENCES country(id);
ALTER TABLE ecosystem_picture ADD CONSTRAINT ecosystem_picture_ecosystem_id_ecosystem_id FOREIGN KEY (ecosystem_id) REFERENCES ecosystem(id) ON DELETE CASCADE;
ALTER TABLE sample ADD CONSTRAINT sample_habitat_id_habitat_id FOREIGN KEY (habitat_id) REFERENCES habitat(id);
ALTER TABLE sample ADD CONSTRAINT sample_environment_id_environment_id FOREIGN KEY (environment_id) REFERENCES environment(id);
ALTER TABLE sample ADD CONSTRAINT sample_ecosystem_id_ecosystem_id FOREIGN KEY (ecosystem_id) REFERENCES ecosystem(id);
ALTER TABLE sample ADD CONSTRAINT sample_collector_id_user_id FOREIGN KEY (collector_id) REFERENCES user(id);
ALTER TABLE user ADD CONSTRAINT user_role_id_role_id FOREIGN KEY (role_id) REFERENCES role(id);
