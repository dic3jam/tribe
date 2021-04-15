<?php
$queries = array (
//class user
	//getters
	"getUserID" => "SELECT userID FROM users WHERE userID = ?",
	"getProPic" => "SELECT pro_pic_loc FROM users WHERE userID = ?", 
	"getAbout" => "SELECT about FROM users WHERE userID = ?", 
	"getUsername" => "SELECT username FROM users WHERE userID = ?",
	"getPassword" => "SELECT password FROM users WHERE userID = ?",
	"getFirstName" => "SELECT firstname FROM users WHERE userID = ?", 
	"getLastName" => "SELECT lastname FROM users WHERE userID = ?", 
	"getLogins" => "SELECT logins FROM users WHERE userID = ?", 
	"getMessageBoardID" => "SELECT messageBoardID FROM users WHERE userID = ?", 
	"getPasswordCreateDate" => "SELECT password_creation_date FROM users WHERE userID = ?", 
	"getAllTribalMemberships" => "SELECT tribe.tribename tribe.tribeID FROM users INNER JOIN tribeMembership USING userID INNER JOIN tribe USING tibeID WHERE userID = ?", 
	"getLastLoginDate" => "SELECT last_login_date FROM users WHERE userID = ?", 
	"getUserCreationDate" => "SELECT user_creation_date FROM users WHERE userID = ?", 
	//setters
	"modTribeMembership" => "INSERT INTO tribeMembership (userID, tribeID, councilMember) VALUES (?,?,?)", //int int boolean
	"setProPic" => "", 
	"setAbout" => "", 
	"setFirstName" => "", 
	"setLastName" => "", 
	"setUsername" => "", 
	"setPassword" => "", 
	"setLogins" => "", 
	"setMessageBoardID" => "", 
	"setPasswordCreateDate" => "", 
	"setAllTribalMemberships" => "", 
	"setLastLoginDate" => "", 
	"setUserCreationDate" => "", 

//class tribe
	//getters
	"getTribeName" => "SELECT tribename FROM tribe WHERE tribeID = ?",
	"getTribeID" => "SELECT tribeID from tribe WHERE tribename = ?",
	//setters
	"removeTribeMembership" => "DELETE FROM tribeMembership WHERE userID = ?",
)
?>
