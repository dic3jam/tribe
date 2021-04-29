<?php
trait query {
static $queries = array (
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
	"getAllTribalMemberships" => "SELECT tribe.tribename, tribe.tribeID FROM tribe INNER JOIN tribeMembership ON tribe.tribeID = tribeMembership.tribeID WHERE userID = ?", //ret assoc array, int
	"getLastLoginDate" => "SELECT last_login_date FROM users WHERE userID = ?", //ret string, int
	"getUserCreationDate" => "SELECT user_creation_date FROM users WHERE userID = ?", //ret string, int
	"getMessageBoardID" => "SELECT messageBoardID from messageboard WHERE userID = ?", //ret s, i
	
	//setters
	"createNewUser" => "INSERT INTO users (username, password, password_creation_date, user_creation_date, firstname, lastname, pro_pic_loc, about, logins, last_login_date) VALUES (?, SHA1(?), NOW(), NOW(), ?, ?, ?, ?, 1, NOW())", //username, password, firstname, lastname, pro_pic_loc, about, ssssss 
	"modTribeMembership" => "UPDATE tribeMembership SET userID = ?, tribeID = ? councilMember = ?", //int int boolean
	"addTribeMembership" => "INSERT into tribeMembership (userID, tribeID, councilMember) VALUES (?,?,?)",
	"setProPic" => "UPDATE users SET pro_pic_loc = ? WHERE userID = ?", //string int 
	"setAbout" => "UPDATE users SET about = ? WHERE userID= ?", //string int
	"setFirstName" => "UPDATE users SET firstname = (?) WHERE userID=(?)", //string, int
	"setLastName" => "UPDATE users SET lastname = (?) WHERE userID=(?)", //string int
	"setUsername" => "UPDATE users SET username = (?) WHERE userID=(?)", //string int
	"setPassword" => "UPDATE users SET password = SHA1(?) WHERE userID=(?)", //string int
	"updateLogins" => "UPDATE users SET logins = logins + 1 WHERE userID=(?)", //int
	"createMessageBoardID" => "INSERT INTO messageboard (userID) VALUES (?)",//int (userID)	
	//"setMessageBoardID" => "UPDATE users (messageBoardID) VALUES (?) WHERE userID=(?)", //int int
	"setPasswordCreateDate" => "UPDATE users SET password_creation_date = NOW() WHERE userID=(?)", //int
	//"setAllTribalMemberships" => "", 
	"setLastLoginDate" => "UPDATE users SET last_login_date = NOW() WHERE userID=(?)", //int
	"setUserCreationDate" => "UPDATE users SET user_creation_date = NOW() WHERE userID=(?)", //int

	//getters
	"getTribeName" => "SELECT tribename FROM tribe WHERE tribeID = ?",
	"getTribeID" => "SELECT tribeID from tribe WHERE tribename = ?",
	//setters
	"removeTribeMembership" => "DELETE FROM tribeMembership WHERE userID = ?",
);
}
?>
