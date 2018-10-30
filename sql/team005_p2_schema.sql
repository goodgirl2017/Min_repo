
-- CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
CREATE USER IF NOT EXISTS gatechUser@localhost IDENTIFIED BY 'gatech123';

DROP DATABASE IF EXISTS `cs6400_spring18_team005`;
SET default_storage_engine=InnoDB;
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE DATABASE IF NOT EXISTS cs6400_spring18_team005
DEFAULT CHARACTER SET utf8mb4
DEFAULT COLLATE utf8mb4_unicode_ci;
USE cs6400_spring18_team005;

GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'gatechUser'@'localhost';
GRANT ALL PRIVILEGES ON `gatechuser`.* TO 'gatechUser'@'localhost';
GRANT ALL PRIVILEGES ON `cs6400_spring18_team005`.* TO 'gatechUser'@'localhost';
FLUSH PRIVILEGES;

-- Tables
CREATE TABLE AdministrativeUser(
username varchar(250) NOT NULL,
position varchar(100) NOT NULL,
PRIMARY KEY(username)
);

CREATE TABLE `User`(
username varchar(250) NOT NULL,
password varchar(60) NOT NULL,
first_name varchar(100) NOT NULL,
last_name varchar(100) NOT NULL,
PRIMARY KEY(username)
);

CREATE TABLE RegularUser(
username varchar(250) NOT NULL,
PRIMARY KEY(username)
);

CREATE TABLE `Item`(
ItemID integer unsigned NOT NULL AUTO_INCREMENT,
username varchar(250) NOT NULL,
returnable ENUM('False','True') NOT NULL,
-- condition cannot be used, it is changed to condition_state
condition_state ENUM('1','2','3','4','5') NOT NULL,
item_name varchar(100) NOT NULL,
description varchar(1000) NOT NULL,
categoryname varchar(50) NOT NULL,
minimum_sale_price DECIMAL(19,4) NOT NULL,
starting_bid DECIMAL(19,4) NOT NULL,
auction_length ENUM('1','3','5','7') NOT NULL,
get_it_now_price DECIMAL(19,4) NULL,
start_sell_time datetime NOT NULL,
winner varchar(250),
PRIMARY KEY(ItemID,username)
);

CREATE TABLE Category(
-- changed to categoryname
categoryname varchar(50) NOT NULL,
PRIMARY KEY(categoryname)
);

CREATE TABLE Rating(
-- itemID is added.
ItemID integer unsigned NOT NULL AUTO_INCREMENT,
username varchar(250) NOT NULL,
comments varchar(1000) NULL,
number_of_stars Tinyint(1) NOT NULL,
rate_time datetime NOT NULL,
PRIMARY KEY(ItemID,username)
);

CREATE TABLE Bid(
username varchar(250) NOT NULL,
-- ItemID is added.
ItemID integer unsigned NOT NULL AUTO_INCREMENT,
bid_time datetime NOT NULL,
bid_amount DECIMAL(19,4) NOT NULL,
PRIMARY KEY(ItemID,username,bid_time)
);

-- Constraints Foreign Keys: FK_ChildTable_childColumn_ParentTable_parentColumn

ALTER TABLE AdministrativeUser
	ADD CONSTRAINT fk_AdministrativeUser_username_User_username FOREIGN KEY(username) REFERENCES `User`(username);

ALTER TABLE RegularUser
	ADD CONSTRAINT fk_RegularUser_username_User_username FOREIGN KEY(username) REFERENCES `User`(username);

ALTER TABLE Item
	ADD CONSTRAINT fk_Item_username_User_username FOREIGN KEY(username) REFERENCES `User`(username);

ALTER TABLE Rating
	ADD CONSTRAINT fk_Rating_username_User_username FOREIGN KEY(username) REFERENCES `User`(username),
	ADD CONSTRAINT fk_Rating_ItemID_Item_ItemID FOREIGN KEY(ItemID) REFERENCES `Item`(ItemID);   

ALTER TABLE Bid
	ADD CONSTRAINT fk_Bid_username_User_username FOREIGN KEY(username) REFERENCES `User`(username),
	ADD CONSTRAINT fk_Bid_ItemID_Item_ItemID FOREIGN KEY(ItemID) REFERENCES `Item`(ItemID);    