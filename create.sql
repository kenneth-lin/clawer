CREATE TABLE k_crawler.urls (
ID int(11)  NOT NULL auto_increment Primary Key,
url varchar(255) NOT NULL,
title TEXT
);

CREATE TABLE k_crawler.context (
ID int(11)  NOT NULL auto_increment Primary Key,
url varchar(255) NOT NULL,
title TEXT,
description TEXT,
created_time date
);