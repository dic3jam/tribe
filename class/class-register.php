<?php 
declare(strict_types=1);
include 'class-dbc.php';
//require 'Exceptions.php';
include 'trait/trait-messageBoard.php';
include 'trait/trait-username.php';
include 'trait/trait-password.php';
//include 'trait/trait-ID.php';
/* class - register
 * Registers a new user
 */
class register {
	use messageBoard;
//	use ID;
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
	public function __construct() {
		try {
			$this->dbc = new dbc();
			password::validPassword((string)$_POST['password']);
			username::validUsername((string)$_POST['username']);
			$username = (string)$_POST['username'];
			$this->dbc->runQuery('createNewUser', 'ssssssi', 
				(string)$_POST['username'], 
				(string)$_POST['password'], 
				(string)$_POST['firstName'].
				(string)$_POST['lastName'],
				(string)$_POST['pro_pic_loc'].
				(string)$_POST['about']
			);
				messageBoard::createMessageBoardID(ID::getUserID($username, $this->dbc()));
				$isRegistered = true;
		} catch (Exception $e) {
			$errors[] = $e->getMessage();
			$isRegistered = false;
			header("Location: login.php");
			exit();
		}
		$this->repOk();
	}

	private function repOk() : void {
		try{
			assert($this->isRegistered == true);
			assert($this->username != NULL);
			assert($this->dbc->connected == 0);
		} catch (Exception $e) {
				$errors[] = "Registration invalid";
				header("Location: login.php");
				exit();
		}

	}

	public function toString() : string {
		return "Register: " .
		       "username: " . $this->username .
		       "isRegistered: " . $this->isRegistered . 
		       "DBC: " . $this->dbc->toString();
		       ;
	}

	public function advance() : bool {
		$this->repOk();
		header("Location: login.php");
		return true;
	}

}
?>
