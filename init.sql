CREATE DATABASE IF NOT EXISTS `buggyvault`;

USE `buggyvault`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `role` ENUM('guest', 'moderator') NOT NULL DEFAULT 'guest',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC)
);

CREATE TABLE IF NOT EXISTS `discussions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `image_path` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_count` INT NOT NULL DEFAULT 0,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_discussions_users_idx` (`user_id` ASC),
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
  INDEX `fk_posts_discussions_idx` (`discussion_id` ASC),
  INDEX `fk_posts_users_idx` (`user_id` ASC),
  CONSTRAINT `fk_posts_discussions`
    FOREIGN KEY (`discussion_id`)
    REFERENCES `buggyvault`.`discussions` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_posts_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `buggyvault`.`users` (`id`)
    ON DELETE CASCADE
);

INSERT INTO `users` (`username`, `password`, `email`, `role`)
VALUES
('crazyboy', 'letmein', 'crazyboy@email.com', 'guest'),
('godfather', 'pass123', 'godfather@email.com', 'guest'),
('sindirella', 'sindirella123', 'sindirella@email.com', 'guest');

INSERT INTO `discussions` (`title`, `content`, `image_path`, `user_id`)
VALUES
('Let`s discuss', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', "images/lets_discuss.jpg", 1),
('OMG What Happened!!', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', "images/omg.jpg", 1),
('BuggyVault is a nice place', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', "images/thumbs_up.png", 3);
('I`m hiring a driver', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', "images/driver.jpg", 2);

INSERT INTO `posts` (`content`, `image_path`, `discussion_id`, `user_id`)
VALUES
('I think it is a good idea to discuss this topic.', "images/thumbs_up.png", 1, 2),
('I agree with you, let`s talk about it.', "images/thumbs_up.png", 1, 3),
('I think we should focus on the bugs first.', "images/thumbs_up.png", 2, 1),
('I have some ideas about the bugs.', "images/thumbs_up.png", 2, 3),
('I love this place!', "images/thumbs_up.png", 3, 1),
('I think we can make it even better!', "images/thumbs_up.png", 3, 2);