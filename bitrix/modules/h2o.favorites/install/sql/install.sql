CREATE TABLE h2o_favorites (
	ID int NOT NULL auto_increment,
	ACTIVE char(1) not null DEFAULT 'Y',
	DATE_INSERT datetime NOT NULL,
	DATE_UPDATE datetime NULL,
	USER_ID int NULL,
	COOKIE_USER_ID varchar(64) NULL,
	ELEMENT_ID int NOT NULL,
	primary key (ID)
);
