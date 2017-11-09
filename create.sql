CREATE TABLE urls (
ID int(11)  NOT NULL auto_increment Primary Key,
url varchar(255) NOT NULL,
title TEXT
);

CREATE TABLE context (
ID int(11)  NOT NULL auto_increment Primary Key,
url varchar(255) NOT NULL,
title TEXT,
description TEXT,
created_time date
);