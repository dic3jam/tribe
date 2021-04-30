<?php 
declare(strict_types=1);
/* trait - username
 * defines a set of functions for 
 * manipulating usernames
 */
trait username {

	/* function checkUsername
	 * Queries the database for the existence of the
	 * provided username
	 * @param string username - the requested username
	 * @return int the userID of that username, or -1 if 
	 * the userName is not in the database
	 */
	public function checkUsername(string $username, object $dbc) : bool {
		try {
			self::getUsername($username, $dbc);
		} catch(Exception $e){
				throw new invalidUsernameException("Username is incorrect");
				return false;
		} 
		return true;	
	}

	/* function validUsername
	 * validates if username is appropriate
	 * @param string username - the username to check
	 * @throws invalidUserNameException if a non-valid username is provided
	 * @return bool true if valid, false if not
	 */
	public function validUsername(string $username) : bool {
		//will implement for v2 for now all usernames are valid
		return true;
	}

	public function getUsername(int $userID, object $dbc) : string {
		return $dbc->runQuery('getUsername','i', $userID);
	}

	public function setUsername(string $newUsername, int $userID, object $dbc) : bool {
		return $dbc->runQuery('setUsername','si', $newUsername, $userID);
	}


}
?>
