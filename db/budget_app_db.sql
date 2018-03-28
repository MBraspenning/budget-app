DROP DATABASE IF EXISTS `budget_app_db`;
CREATE DATABASE `budget_app_db` CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

USE `budget_app_db`;

DROP TABLE IF EXISTS `budget`;
CREATE TABLE `budget`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `month` INT NOT NULL,
    `year` INT NOT NULL,
    `total_income` DECIMAL(12,2) NOT NULL DEFAULT 0.0,
    `total_expense` DECIMAL(12,2) NOT NULL DEFAULT 0.0,
    `total_budget` DECIMAL(12,2) NOT NULL DEFAULT 0.0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

DROP TABLE IF EXISTS `income`;
CREATE TABLE `income`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `income` VARCHAR(255) NOT NULL DEFAULT '',
    `amount` DECIMAL(12,2) NOT NULL DEFAULT 0.0,
    `added_date` DATE NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

DROP TABLE IF EXISTS `expense`;
CREATE TABLE `expense`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `expense` VARCHAR(255) NOT NULL DEFAULT '',
    `amount` DECIMAL(12,2) NOT NULL DEFAULT 0.0,
    `added_date` DATE NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

INSERT INTO `budget` (`month`, `year`, `total_budget`, `total_income`, `total_expense`) VALUES (MONTH(NOW()), YEAR(NOW()) ,0.00, 0.00, 0.00);