-- MySQL dump 10.13  Distrib 5.7.12, for Linux (x86_64)
--
-- Host: localhost    Database: beejee
-- ------------------------------------------------------
-- Server version	5.6.22-71.0-log

CREATE TABLE `comments` (
  `id`     INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`   VARCHAR(255)     NOT NULL,
  `email`  VARCHAR(255)     NOT NULL,
  `text`   TEXT             NOT NULL,
  `show`   TINYINT(1)       NOT NULL DEFAULT '0',
  `edited` TINYINT(1)       NOT NULL DEFAULT '0',
  `image`  CHAR(64)                  DEFAULT NULL,
  `date`   TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = latin1;
