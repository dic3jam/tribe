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
	private function checkUsername(string $username) : int {

	}

	/* function changeUsername
	 * Changes a username to the new string
	 * @param string username - the current username
	 * @param string newUsername - the new userName
	 * @return boolean indicating success or failure
	 */
	private function changeUsername(string $username, string $newUsername) : boolean {}

	/* function validUsername
	 * validates if username is appropriate
	 * @param string username - the username to check
	 * @throws invalidUserNameException if a non-valid username is provided
	 * @return boolean true if valid, false if not
	 */
	private function validUsername(string $username) : boolean {
		//will implement for v2 for now all usernames are valid
		return true;
	}
}
?>
