<?php 
declare(strict_types=1);
include 'class-dbc.php';
include 'trait/trait-queryFunctions.php';
include 'include/queries.php';
include 'trait/messageBoard.php';
include 'trait/trait-username.php';
include 'trait/trait-password.php';
/* class - register
 * Registers a new user
 */
class register {
	use queryFunctions;
	use password;
	use username;

	private bool $isRegistered;
	private string $username;
	private object $dbc;

	/* function register
	 * Performs a user registration by sending new info
	 * to the database
	 * Note: Sanitizing user input is handled at the form
	 * @param string username - from $_POST
	 * @param string password - from $_POST
	 * @return bool upon success
	 * @throws invalidPasswordException, invalidUserException, 
	 * passwordLengthException
	 */
	public function __construct(array $queries) {
		$this->dbc = new dbc($queries);
		if(validPassword((string)$_POST['password']));
		else {
			throw new invalidPasswordException();
			$isRegistered = false;
		}
		if(validUsername(((string)$_POST['username'])))
			$username = (string)$_POST['username'];
		else{
			throw new invalidUserNameException();
			$isRegistered = false;
		}
		if(runQuery('createNewUser', $this->dbc, 'ssssssi', " failed to create new user", 
			(string)$_POST['username'], 
			(string)$_POST['password'], 
			(string)$_POST['firstName'].
			(string)$_POST['lastName'],
			(string)$_POST['pro_pic_loc'].
			(string)$_POST['about']
			)){
			createMessageBoardID(getUserID($username), $this->dbc);
			$isRegistered = true;
		}else
			$isRegistered = false;

	}

	private function repOk() : bool {
		assert($this->isRegistered == true);
		assert($this->username != NULL);
		assert($this->dbc->connect_errno == 0);
	}

	public function toString() : string {
		return "Register: " .
		       "username: " . $this->username .
		       "isRegistered: " . $this->isRegistered . 
		       "DBC: " . $this->dbc->toString();
		       ;
	}

	public function advance() : bool {
		if(repOk()){
			header("Location: login.php");
			return true;
		}else
			return false;
	}

	private function getUserID(string $username) : int {
		return runQuery('getUserID', $this->dbc,'s', " failed to get userID", $username);
	}

}
?>
