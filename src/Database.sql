-- CREATE SCHEMA `postpad` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
-- USE `postpad`;

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `content` varchar(500) NOT NULL,
  `timestamp` int(20) NOT NULL,
  `invalid` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`));



CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `displayname` varchar(25) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `authseed` varchar(45) DEFAULT NULL,
  `isuserstaff` int(1) NOT NULL DEFAULT 0,
  `isuserverified` int(1) NOT NULL DEFAULT 0,
  `isuserdeveloper` int(1) NOT NULL DEFAULT 0,
  `isuserpatron` int(1) NOT NULL DEFAULT 0,
  `pfppath` varchar(100) DEFAULT '/public/res/img/pfps/default_pfp_square.png',
  `signupday` date NOT NULL,
  `bio` varchar(150) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `privateprofile` int(1) NOT NULL DEFAULT 0,
  `timezone` varchar(45) NOT NULL DEFAULT 'GMT',
  PRIMARY KEY (`id`));

CREATE TABLE `follows` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `followed` INT(11) NOT NULL,
  `follower` INT(11) NOT NULL,
  PRIMARY KEY (`id`));

-- Content ID column has been removed as it is redundant
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL DEFAULT 0 COMMENT '0-short,1-long,2-reblog',
  `posting_user` int(11) NOT NULL,
  `sharecount` int(11) NOT NULL DEFAULT 0,
  `reblogs` int(11) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `timestamp` int(20) NOT NULL,
  `cw_general` int(1) NOT NULL DEFAULT 0,
  `cw_nsfw` int(1) NOT NULL DEFAULT 0,
  `reply_to` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`));


CREATE TABLE `postcontent` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `postid` INT NOT NULL,
  `posting_user` INT NOT NULL,
  `content` VARCHAR(8000) NOT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `userlogins` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `userid` INT NOT NULL,
  `devicetype` INT(1) NOT NULL COMMENT '0-browser,1-app',
  `agent` VARCHAR(150) NOT NULL,
  `sessionid` VARCHAR(128) NOT NULL,
  `logintimestamp` VARCHAR(12) NOT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `bans` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `userid` INT NULL,
  `useremail` VARCHAR(50) NULL,
  `ispermanent` INT(1) NOT NULL DEFAULT 0,
  `expires` DATETIME NOT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `invitecodes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `invitecode` VARCHAR(35) NOT NULL,
  `used` INT(1) NOT NULL DEFAULT 0,
  `user` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`));


CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL COMMENT '0-info,1-warn,2-error',
  `function` varchar(150) NOT NULL,
  `message` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `api_access` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `appid` VARCHAR(100) NOT NULL COMMENT 'Such as \"eu.postpad.android\"',
  `appname` VARCHAR(100) NOT NULL COMMENT 'Such as \"PostPad for Android\"',
  `accesskey` VARCHAR(150) NOT NULL COMMENT 'Randomly generated API key',
  `owner` INT(11) NULL COMMENT "User ID of the app\'s owner (optional)",
  PRIMARY KEY (`id`));