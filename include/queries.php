<?php
$queries = array (
//class user
	//getters
	"getUserID" => "SELECT userID FROM users WHERE username = ?", //s
	"getProPic" => "SELECT pro_pic_loc FROM users WHERE userID = ?", //ret string, int 
	"getAbout" => "SELECT about FROM users WHERE userID = ?", //ret string, int
	"getUsername" => "SELECT username FROM users WHERE userID = ?", //ret string, int
	"getPassword" => "SELECT password FROM users WHERE userID = ?",  //ret string, int
	"getFirstName" => "SELECT firstname FROM users WHERE userID = ?", //ret string, int
	"getLastName" => "SELECT lastname FROM users WHERE userID = ?", //ret string, int
	"getLogins" => "SELECT logins FROM users WHERE userID = ?", //ret s, i
	"getPasswordCreateDate" => "SELECT password_creation_date FROM users WHERE userID = ?", //ret string, int
	"getAllTribalMemberships" => "SELECT tribe.tribename tribe.tribeID FROM users INNER JOIN tribeMembership USING userID INNER JOIN tribe USING tibeID WHERE userID = ?", //ret assoc array, int
	"getLastLoginDate" => "SELECT last_login_date FROM users WHERE userID = ?", //ret string, int
	"getUserCreationDate" => "SELECT user_creation_date FROM users WHERE userID = ?", //ret string, int
	"getMessageBoardID" => "SELECT messageBoardID from messageboard WHERE userID = ?", //ret s, i
	//
	//setters
	"createNewUser" => "INSERT INTO users (username, password, password_creation_date, user_creation_date, firstname, lastname, pro_pic_loc, about, logins, last_login_date) VALUES (?, SHA1(?), NOW(), NOW(), ?, ?, ?, ?, 1, NOW())", //string string string string string string 
	"modTribeMembership" => "UPDATE tribeMembership (userID, tribeID, councilMember) VALUES (?,?,?)", //int int boolean
	"setProPic" => "UPDATE users (pro_pic_loc) VALUES (?) WHERE userID=(?)", //string int 
	"setAbout" => "UPDATE users (about) VALUES (?) WHERE userID=(?)", //string int
	"setFirstName" => "UPDATE users (firstname) VALUES (?) WHERE userID=(?)", //string, int
	"setLastName" => "UPDATE users (lastname) VALUES (?) WHERE userID=(?)", //string int
	"setUsername" => "UPDATE users (username) VALUES (?) WHERE userID=(?)", //string int
	"setPassword" => "UPDATE users (password) VALUES (SHA1(?)) WHERE userID=(?)", //string int
	"updateLogins" => "UPDATE SET logins = logins + 1 WHERE userID=(?)", //int
	"createMessageBoardID" => "INSERT INTO messageboard (userID) VALUES (?)",//int (userID)	
	//"setMessageBoardID" => "UPDATE users (messageBoardID) VALUES (?) WHERE userID=(?)", //int int
	"setPasswordCreateDate" => "UPDATE users (password_creation_date) VALUES NOW() WHERE userID=(?)", //int
	//"setAllTribalMemberships" => "", 
	"setLastLoginDate" => "UPDATE users (last_login_date) VALUES NOW() WHERE userID=(?)", //int
	"setUserCreationDate" => "UPDATE users (user_creation_date) VALUES NOW() WHERE userID=(?)", //int

//class tribe
	//getters
	"getTribeName" => "SELECT tribename FROM tribe WHERE tribeID = ?",
	"getTribeID" => "SELECT tribeID from tribe WHERE tribename = ?",
	//setters
	"removeTribeMembership" => "DELETE FROM tribeMembership WHERE userID = ?",
)
?>
