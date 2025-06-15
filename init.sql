CREATE DATABASE IF NOT EXISTS `buggyvault`;

USE `buggyvault`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `role` ENUM('guest', 'moderator') NOT NULL DEFAULT 'guest',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE
);

CREATE TABLE IF NOT EXISTS `discussions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `image_path` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_discussions_users_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_discussions_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `buggyvault`.`users` (`id`)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `posts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `content` TEXT NOT NULL,
  `image_path` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `discussion_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_posts_discussions_idx` (`discussion_id` ASC) VISIBLE,
  INDEX `fk_posts_users_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_posts_discussions`
    FOREIGN KEY (`discussion_id`)
    REFERENCES `buggyvault`.`discussions` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_posts_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `buggyvault`.`users` (`id`)
    ON DELETE CASCADE
);