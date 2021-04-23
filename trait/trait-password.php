<?php 
declare(strict_types=1);
include '../include/queries.php';
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
	 * @return boolean indicating success
	 */
	private function checkPassword(int $userId, string $password) : boolean {
		if(sha1($password) == getPassword($userID))
			return true;
		else
			return false;		
	}

	/* function validPassword
	 * Checks password for correct length 
	 * and security strength
	 * @param string password - the password to check
	 * @throw passwordLengthException, invalidPasswordException
	 * @return boolean indicating success
	 */
	private function validPassword(string $password) : boolean {
		if(strlen($password) < 20)
			return true;
		else
			return false;
		
	}

}
?>
