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
	 */
	public function checkPassword(int $userID, string $password, object $dbc) : bool {
		if(sha1($password) == self::getPassword($userID, $dbc))
			return true;
		else
			return false;		
	}

	/* function validPassword
	 * Checks password for correct length 
	 * and security strength
	 * @param string password - the password to check
	 * @throws passwordLengthException, invalidPasswordException
	 * @return bool indicating success
	 */
	public function validPassword(string $password) : bool {
		if(strlen($password) < 20)
			return true;
		else
			return false;
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
		$userID = getUserID($username);
		if(self::checkPassword($userID, $newPassword)){
			self::setPasswordCreateDate($userID);
			return self::setPassword($newPassword, $userID);
		}else
			return false;
	}

	private function getPassword(int $userID, object $dbc) : string {
		return queryFunctions::runQuery('getPassword', $dbc,'i', " failed to get password", $userID);
	}

	private function setPassword(string $password, int $userid, object $dbc) : bool {
		return queryFunctions::runQuery('setPassword', $dbc,'si', " failed to set new password", $userid);
	}

	private function setPasswordCreateDate(int $userID, object $dbc) : bool {
		return queryFunctions::runQuery('setPasswordCreateDate', $dbc,'i', " failed to set passwordCreateDate", $userID);
	}

	private function getPasswordCreateDate(object $dbc) : string {
		return queryFunctions::runQuery('getPasswordCreatedate', $dbc,'i', " failed to get passwordCreateDate", $this->userID);
	}

}
?>
