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

INSERT IGNORE INTO `users` (`username`, `password`, `email`, `role`)
VALUES
('crazyboy', 'letmein', 'crazyboy@email.com', 'guest'),
('godfather', 'pass123', 'godfather@email.com', 'guest'),
('sindirella', 'sindirella123', 'sindirella@email.com', 'guest');

INSERT INTO `discussions` (`title`, `content`, `image_path`, `user_id`, `post_count`)
SELECT * FROM (SELECT
  'Let`s discuss' AS `title`,
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' AS `content`,
  'images/lets_discuss.jpg' AS `image_path`,
  1 AS `user_id`,
  2 AS `post_count`
) AS `tmp`
WHERE NOT EXISTS (
  SELECT 1 FROM `discussions` WHERE `title` = 'Let`s discuss' AND `user_id` = 1
);

INSERT INTO `discussions` (`title`, `content`, `image_path`, `user_id`,  `post_count`)
SELECT * FROM (SELECT
  'OMG What Happened!!' AS `title`,
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' AS `content`,
  'images/omg.jpg' AS `image_path`,
  1 AS `user_id`,
  2 AS `post_count`
) AS `tmp`
WHERE NOT EXISTS (
  SELECT 1 FROM `discussions` WHERE `title` = 'OMG What Happened!!' AND `user_id` = 1
);

INSERT INTO `discussions` (`title`, `content`, `image_path`, `user_id`, `post_count`)
SELECT * FROM (SELECT
  'BuggyVault is a nice place' AS `title`,
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' AS `content`,
  'images/thumbs_up.png' AS `image_path`,
  2 AS `user_id`,
  2 AS `post_count`
) AS `tmp`
WHERE NOT EXISTS (
  SELECT 2 FROM `discussions` WHERE `title` = 'BuggyVault is a nice place' AND `user_id` = 2
);

INSERT INTO `discussions` (`title`, `content`, `image_path`, `user_id`, `post_count`)
SELECT * FROM (SELECT
  'I`m hiring a driver' AS `title`,
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' AS `content`,
  'images/driver.jpg' AS `image_path`,
  3 AS `user_id`,
  2 AS `post_count`
) AS `tmp`
WHERE NOT EXISTS (
  SELECT 3 FROM `discussions` WHERE `title` = 'I`m hiring a driver' AND `user_id` = 3
);

INSERT INTO `posts` (`content`, `image_path`, `discussion_id`, `user_id`)
SELECT * FROM (SELECT
  'I think it is a good idea to discuss this topic.' AS `content`,
  'images/thumbs_up.png' AS `image_path`,
  1 AS `discussion_id`,
  1 AS `user_id`
) AS `tmp`
WHERE NOT EXISTS (
  SELECT 1 FROM `posts` WHERE `content` = 'I think it is a good idea to discuss this topic.' AND `user_id` = 1
);

INSERT INTO `posts` (`content`, `image_path`, `discussion_id`, `user_id`)
SELECT * FROM (SELECT
  'I agree with you, let`s talk about it.' AS `content`,
  'images/thumbs_up.png' AS `image_path`,
  1 AS `discussion_id`,
  2 AS `user_id`
) AS `tmp`
WHERE NOT EXISTS (
  SELECT 1 FROM `posts` WHERE `content` = 'I agree with you, let`s talk about it.' AND `user_id` = 2
);

INSERT INTO `posts` (`content`, `image_path`, `discussion_id`, `user_id`)
SELECT * FROM (SELECT
  'I think we should focus on the bugs first.' AS `content`,
  'images/thumbs_up.png' AS `image_path`,
  2 AS `discussion_id`,
  3 AS `user_id`
) AS `tmp`
WHERE NOT EXISTS (
  SELECT 1 FROM `posts` WHERE `content` = 'I think we should focus on the bugs first.' AND `user_id` = 3
);

INSERT INTO `posts` (`content`, `image_path`, `discussion_id`, `user_id`)
SELECT * FROM (SELECT
  'I have some ideas about the bugs.' AS `content`,
  'images/thumbs_up.png' AS `image_path`,
  2 AS `discussion_id`,
  1 AS `user_id`
) AS `tmp`
WHERE NOT EXISTS (
  SELECT 1 FROM `posts` WHERE `content` = 'I have some ideas about the bugs.' AND `user_id` = 1
);

INSERT INTO `posts` (`content`, `image_path`, `discussion_id`, `user_id`)
SELECT * FROM (SELECT
  'I love this place!' AS `content`,
  'images/thumbs_up.png' AS `image_path`,
  3 AS `discussion_id`,
  2 AS `user_id`
) AS `tmp`
WHERE NOT EXISTS (
  SELECT 1 FROM `posts` WHERE `content` = 'I love this place!' AND `user_id` = 2
);

INSERT INTO `posts` (`content`, `image_path`, `discussion_id`, `user_id`)
SELECT * FROM (SELECT
  'I think we can make it even better!' AS `content`,
  'images/thumbs_up.png' AS `image_path`,
  3 AS `discussion_id`,
  3 AS `user_id`
) AS `tmp`
WHERE NOT EXISTS (
  SELECT 1 FROM `posts` WHERE `content` = 'I think we can make it even better!' AND `user_id` = 3
);