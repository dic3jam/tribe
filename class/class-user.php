<?php 
declare(strict_types=1);
include '../trait/trait-dbconnect.php';
include '../trait/trait-authlogin.php';
include '../trait/trait-username.php';
include '../trait/trait-password.php';
include '../include/queries.php';
/* class - User
 * Enables user access to tribe.com. 
 * Provides functions for registration, login
 * edititng info, and displaying a profile page
 */
class User {
	use username; 
	use password;
	use dbconnect; 
	use authLogin;

	//admin
	private array $queries;
	private object $dbc;
	private array $auth;
	//User properties
	private string $username;
	private string $password;
	private string $firstName;
	private string $lastName;
	private int $num_logins;
//	private $messageBoardID;
	private string $pass_update_date;
	private string $last_login;
	private array /*int*/ $tribe_memberships;

	//constructors

	public function __construct(array $queries, array $auth, object $dbc){

	}

	//repOK, toString

	private function repOk() : boolean {

	}

	public function toString() : string {

	}
	
	//static functions

	/* function register
	 * Performs a user registration by sending new info
	 * to the database
	 * Note: Sanitizing user input is handled at the form
	 * @param array post - a copy of the current $_POST array
	 * @return boolean upon success
	 */
	public static function register(array $post) : boolean{

	}

	/* function login
	 * Completes a user login by checking username 
	 * and password and providing a login cookie
	 * @param string username - username from $_POST
	 * @param string password - password from $_POST
	 * @return boolean if login successful, constructs a login cookie
	 */
	public static function login(string $username, string $password) : boolean{

	}

	/* function changePassword
	 * Checks a user login and if correct, queries the
	 * database to change the password to the new password string 
	 * @param string username - username from $_POST
	 * @param string password - password from $_POST
	 * @param string newPassword - new password from $_POST
	 * @return boolean if change password was successful
	 */
	public static function changePassword(string $username, string $password, string $newPassword) : boolean{
	
	}

	/* function createLoginCookie
	 * Generates the login cookie
	 * for a successful login
	 * @param int userID
	 * @return boolean indicating success
	 * note: for v1 all cookies are just userId and the "key"
	 */
	private function createLoginCookie(int $userID) : boolean {}

	//getters

	private function getProPic() : string {}

	private function getAbout() : string {}

	private function getFirstName() : string {}

	private function getLastName() : string {}

	private function getLogins() : int {}

	private function getMessageBoardID() : int {}

	private function getPasswordCreateDate() : string {}

	private function getAllTribalMemberships() : string {}

	private function getLastLoginDate() : string {}

	private function getUserCreationDate() : string {}

	//setters
	
	//for adding to tribe, adding/removing council member status	
	private function modTribeMembership() : boolean {}

	private function setProPic() : boolean {}

	private function setAbout() : boolean {}

	private function setFirstName() : boolean {}

	private function setLastName() : boolean {}

	private function setLogins() : boolean {}

	private function setMessageBoardID() : boolean {}

	private function setPasswordCreateDate() : boolean {}

	private function setAllTribalMemberships() : boolean {}

	private function setLastLoginDate() : boolean {}

	private function setUserCreationDate() : boolean {}
}
 ?>
