<?php 
declare(strict_types=1);
/* trait - password
 * defines a set of functions for 
 * manipulating passwords
 */
trait password {

	/* function checkPassword
	 * Checks database at inputted userId
	 * to see if it matches
	 * @param int userId
	 * @param string password
	 * @return bool indicating success
	 * @throws invalidPasswordException
	 */
	public function checkPassword(int $userID, string $password, object $dbc) : bool {
		if(sha1($password) == self::getPassword($userID, $dbc))
			return true;
		else{
			throw new invalidPasswordException("Incorrect password");
			return false;		
		}
	}

	/* function validPassword
	 * Checks password for correct length 
	 * and security strength
	 * @param string password - the password to check
	 * @throws passwordLengthException, invalidPasswordException
	 * @return bool indicating success
	 */
	public function validPassword(string $password) : bool {
		if(strlen($password) < 40)
			return true;
		else{
			throw new passwordLengthException("Password is too long");
			return false;
		}
	}

	/* function changePassword
	 * Checks a user login and if correct, queries the
	 * database to change the password to the new password string 
	 * @param string username - username from $_POST
	 * @param string password - password from $_POST
	 * @param string newPassword - new password from $_POST
	 * @return bool if change password was successful
	 */
	public function changePassword(string $username, string $password, string $newPassword, object $dbc) : bool{
			$userID = ID::getUserID($username, $dbc);
			self::checkPassword($userID, $password, $dbc);
			self::setPasswordCreateDate($userID, $dbc);
			return self::setPassword($newPassword, $userID, $dbc);
	}

	//for use at the edit-user screen (forgoes getting userID, ensuring existing password is valid)
	public function changePasswordEditUser(string $username, string $newPassword, int $userID, object $dbc) : bool{
			self::validPassword($newPassword);
			self::setPasswordCreateDate($userID, $dbc);
			return self::setPassword($newPassword, $userID, $dbc);
	}

	public function getPassword(int $userID, object $dbc) : string {
		return $dbc->runQuery('getPassword','i', $userID);
	}

	public function setPassword(string $password, int $userid, object $dbc) : bool {
		return $dbc->runQuery('setPassword','si', $password, $userid);
	}

	public function setPasswordCreateDate(int $userID, object $dbc) : bool {
		return $dbc->runQuery('setPasswordCreateDate','i', $userID);
	}

	public function getPasswordCreateDate(int $userID, object $dbc) : string {
		return $dbc->runQuery('getPasswordCreateDate','i', $userID);
	}

}
?>
