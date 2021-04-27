<?php 
declare(strict_types=1);
include 'class-dbc.php';
include 'trait/trait-username.php';
include 'trait/trait-password.php';
include 'trait/trait-queryFunctions.php';
/* class - login
 * performs a user login
 */
class login {
	use username;
	use password;
	use queryFunctions;

	private int $userID;
	private string $username;
	private string $password;
	private bool $isValidUser;
	private bool $isSetLogin;
	private $dbc;

	/* login
	 * Completes a user login by checking username 
	 * and password and providing a login cookie
	 * then redirects to the users profile page
	 * @param string username - username from $_POST
	 * @param string password - password from $_POST
	 * @throws badLoginException if login was unsuccessful
	 */
	public function __construct(string $username, string $password, array $queries){
		$this->dbc = new dbc($queries);
		$userID = $this->getUserID($username);
		if(password::checkPassword((int)$userID, $password, $this->dbc)){
			$this->userID = $userID;
			$this->username = $username;
			$this->password = $password;
			$this->isValidUser = true;
			$this->isSetLogin = $this->createLoginToken($username, $userID);
		} else 
			throw new badLoginException;	
	}

	private function repOk() : bool {
		assert($this->dbc->connect_errno == 0);
		assert($this->userID != NULL);
		assert($this->username != NULL);
		assert($this->password != NULL);
		assert($this->isValidUser == true);
		assert($this->isSetLogin == true);
		return true;
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
		if($this->repOk()){
			header("Location: profile.php");
			return true;
		}else
			return false;
	}

	/* function createLoginToken
	 * Generates the login cookie
	 * for a successful login
	 * @param string username
	 * @param int userID
	 * @return bool indicating success
	 * note: for v1 all cookies are just userId and the "key"
	 */
	private function createLoginToken(string $username, int $userID) : bool {
		return setcookie($username, strval($userID));	
	}

	public function getUserID(string $username) {
		return queryFunctions::runQuery('getUserID', $this->dbc,'s', " failed to get userID", $username);
	}

}
?>
