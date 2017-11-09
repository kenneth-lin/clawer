create database `k_crawler`;

USE `k_crawler`;

create table `master_crawler` (
  `id` int(11) auto_increment NOT NULL,
  `crawler_id` int(11) NOT NULL,
  `attribute` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `description` varchar(1024),
  PRIMARY KEY (`id`)
);

