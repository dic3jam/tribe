# Build script for v1 tribe.com database

CREATE DATABASE tribe;

USE tribe;

# Users Table

CREATE TABLE users (
userID INT UNSIGNED NOT NULL AUTO_INCREMENT,
username VARCHAR(20) NOT NULL,
password VARCHAR(20) NOT NULL,
password_creation_date DATETIME NOT NULL,
user_creation_date DATETIME NOT NULL,
firstname VARCHAR(20) NOT NULL,
lastname VARCHAR(20) NOT NULL,
pro_pic_loc VARCHAR(20) NOT NULL,
about NVARCHAR(100) NOT NULL,
logins INT UNSIGNED NOT NULL,
last_login_date INT DATETIME NOT NULL,
messageBoardID INT UNSIGNED,
PRIMARY KEY (userID),
FOREIGN KEY (messageBoardID) references
messsageBoard (messageBoardID),
UNIQUE (username),
UNIQUE (pro_pic_loc),
);

CREATE TABLE tribe (
tribeID INT UNSIGNED NOT NULL AUTO_INCREMENT,
tribename VARCHAR(40) NOT NULL,
tribe_pic_loc VARCHAR(20) NOT NULL,
messsageBoardID INT UNSIGNED,
PRIMARY KEY (tribeID),
FOREIGN KEY (messageBoardID) references
messsageBoard (messageBoardID),
UNIQUE (tribename),
UNIQUE (tribe_pic_loc),
);

CREATE TABLE tribeMembership (
userID INT UNSIGNED NOT NULL,
tribeID INT UNSIGNED NOT NULL,
councilMember BOOLEAN NOT NULL,
FOREIGN KEY (userID) references
users (userID),
FOREIGN KEY (tribeID) references
tribe (tribeID),
);


CREATE TABLE messageboardposts (
messageBoardID INT UNSIGNED NOT NULL AUTO_INCREMENT,
postID INT UNSIGNED NOT NULL,
PRIMARY KEY (messageBoardID),
FOREIGN KEY (postID) references
posts (postID),
);

CREATE TABLE posts (
postID INT UNSIGNED NOT NULL AUTO_INCREMENT,
creation_time DATETIME NOT NULL,
userID INT UNSIGNED NOT NULL,
message NVARCHAR(500),
PRIMARY KEY (postID),
FOREIGN KEY (userID) references
users (userID),
);

