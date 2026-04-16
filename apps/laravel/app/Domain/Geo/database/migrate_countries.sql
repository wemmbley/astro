CREATE TABLE IF NOT EXISTS `countries_ru` (
                                              `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                              `name` TEXT NOT NULL,
                                              `terms` TEXT NOT NULL,
                                              `lat` DOUBLE,
                                              `lon` DOUBLE,
                                              `population` INT DEFAULT 0,
                                              `timezone` TEXT,
                                              `country_code` TEXT
);

CREATE TABLE IF NOT EXISTS `countries_ua` (
                                              `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                              `name` TEXT NOT NULL,
                                              `terms` TEXT NOT NULL,
                                              `lat` DOUBLE,
                                              `lon` DOUBLE,
                                              `population` INT DEFAULT 0,
                                              `timezone` TEXT,
                                              `country_code` TEXT
);

CREATE TABLE IF NOT EXISTS `countries_by` (
                                              `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                              `name` TEXT NOT NULL,
                                              `terms` TEXT NOT NULL,
                                              `lat` DOUBLE,
                                              `lon` DOUBLE,
                                              `population` INT DEFAULT 0,
                                              `timezone` TEXT,
                                              `country_code` TEXT
);

ALTER TABLE countries_ru CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE countries_ua CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE countries_by CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
