<?php 
declare(strict_types=1);
include 'class-dbc.php';
//require 'Exceptions.php';
include '../trait/trait-username.php';
include '../trait/trait-password.php';
include '../trait/trait-ID.php';
/* class - login
 * performs a user login
 */
class login {
	use username;
	use password;
	use ID;

	private int $userID;
	private string $username;
	private string $password;
	private bool $isValidUser;
	private bool $isSetLogin;
	private object $dbc;

	/* login
	 * Completes a user login by checking username 
	 * and password and providing a login cookie
	 * then redirects to the users profile page
	 * @param string username - username from $_POST
	 * @param string password - password from $_POST
	 * @throws badLoginException if login was unsuccessful
	 */
	public function __construct(string $username, string $password){
		$this->dbc = new dbc();
		$this->userID = ID::getUserID($username, $this->dbc);
		password::checkPassword((int)$this->userID, $password, $this->dbc);
		$this->username = $username;
		$this->password = $password;
		$this->isValidUser = true;
		$this->isSetLogin = $this->createLoginToken($this->userID);
		$this->repOk();
	}

	private function repOk() : void {
		assert($this->dbc->connect_errno == 0);
		assert($this->userID != NULL);
		assert($this->username != NULL);
		assert($this->password != NULL);
		assert($this->isValidUser == true);
		assert($this->isSetLogin == true);
	}

	public function toString() : string {
		return "Login: " .
		       ", userID: " . strval($this->userID) .
		       ", username: " . $this->username .
		       ", password: " . $this->password .
		       ", isValidUser: " . $this->isValidUser .
		       ", isSetLogin: " . $this->isSetLogin .
		       $this->dbc->toString()
		       ;
	}

	public function advance() : bool {
		$this->repOk();
		header("Location: profile.php");
		return true;
	}

	/* function createLoginToken
	 * Generates the login cookie
	 * for a successful login
	 * @param string username
	 * @param int userID
	 * @return bool indicating success
	 * note: for v1 all cookies are just userId and the "key"
	 */
	private function createLoginToken(int $userID) : bool {
		$_SESSION['user'] = $userID;
		return true;
	}

}
?>
