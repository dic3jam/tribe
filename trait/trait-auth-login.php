<?php 
/* trait authLogin - defines check_login function 
 * for cehcking that a user is logged in
 */
trait authLogin {
	/* function check_login
	 * Checks that a userID is set in the cookie value field
	 * which is deemed "logged in"
	 * will redirect to login page if no login cookie is set
	 * @return boolean indicating success
	 */
	public function check_login() : bool {
		if(!empty($_SESSION['user'])) {
			return true;
		} else
			throw new notLoggedInException();
			return false;
	}
}
?>
