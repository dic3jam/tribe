# Build script for v1 tribe.com database

CREATE DATABASE tribe;

USE tribe;

CREATE TABLE users (
userID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(20) NOT NULL,
password VARCHAR(40) NOT NULL,
password_creation_date DATETIME NOT NULL,
user_creation_date DATETIME NOT NULL,
firstname VARCHAR(20) NOT NULL,
lastname VARCHAR(20) NOT NULL,
pro_pic_loc VARCHAR(20) NOT NULL,
about NVARCHAR(100) NOT NULL,
logins INT UNSIGNED NOT NULL,
last_login_date DATETIME NOT NULL,
UNIQUE (username),
UNIQUE (pro_pic_loc)
);

CREATE TABLE tribe (
tribeID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
tribename VARCHAR(40) NOT NULL,
tribe_pic_loc VARCHAR(20) NOT NULL,
messageBoardID INT UNSIGNED,
UNIQUE (tribename),
UNIQUE (tribe_pic_loc)
);

CREATE TABLE tribeMembership (
userID INT UNSIGNED NOT NULL,
tribeID INT UNSIGNED NOT NULL,
councilMember BOOLEAN NOT NULL
);

CREATE TABLE messageboard (
messageBoardID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
userID INT UNSIGNED,
tribeID INT UNSIGNED
);

CREATE TABLE messageboardposts (
messageBoardID INT UNSIGNED NOT NULL,
postID INT UNSIGNED NOT NULL
);

CREATE TABLE posts (
postID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
creation_time DATETIME NOT NULL,
userID INT UNSIGNED NOT NULL,
message NVARCHAR(500)
);

ALTER TABLE tribe 
ADD FOREIGN KEY (messageBoardID) references messageboard(messageBoardID)
;

ALTER TABLE tribeMembership 
ADD FOREIGN KEY (userID) references users(userID),
ADD FOREIGN KEY (tribeID) references tribe(tribeID)
;

ALTER TABLE messageboard 
ADD FOREIGN KEY (userID) references users(userID),
ADD FOREIGN KEY (tribeID) references tribe(tribeID)
;

ALTER TABLE messageboardposts 
ADD FOREIGN KEY (messageBoardID) references messageboard(messageBoardID),
ADD FOREIGN KEY (postID) references posts(postID)
;

ALTER TABLE posts 
ADD FOREIGN KEY (userID) references users(userID)
;

#create test user

INSERT INTO users (username, password, password_creation_date, user_creation_date, firstname, lastname, pro_pic_loc, about, logins, last_login_date) VALUES ('jimbo', SHA1('dont.panic'), NOW(), NOW(), 'jim', 'd', 'here',  "Long walks on the beach", 1, NOW());

