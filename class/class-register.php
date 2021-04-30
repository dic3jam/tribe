<?php 
declare(strict_types=1);
include 'class-dbc.php';
//require 'Exceptions.php';
include '../trait/trait-messageBoard.php';
include '../trait/trait-username.php';
include '../trait/trait-password.php';
include '../trait/trait-fileUpload.php';
include '../trait/trait-ID.php';
//include 'trait/trait-ID.php';
/* class - register
 * Registers a new user
 */
class register {
	use messageBoard;
	use ID;
	use password;
	use username;
	use fileUpload;

	private bool $isRegistered;
	private string $username;
	private object $dbc;

	/* function register
	 * Performs a user registration by sending new info
	 * to the database
	 * @param string username - from $_POST
	 * @param string password - from $_POST
	 * @return bool upon success
	 * @throws invalidPasswordException, invalidUserException, 
	 * passwordLengthException
	 */
	public function __construct() {
		$this->dbc = new dbc();
		password::validPassword((string)$_POST['password']);
		username::validUsername((string)$_POST['username']);
		$pro_pic_loc = fileUpload::storeProPic();
		$this->username = (string)$_POST['username'];
		$this->dbc->runQuery('createNewUser', 'ssssss', $this->username, ((string)$_POST['password']), ((string)$_POST['firstName']), ((string)$_POST['lastName']), $pro_pic_loc, ((string)$_POST['about']));
		messageBoard::createMessageBoardID($this->dbc, ID::getUserID($this->username, $this->dbc));
		$this->isRegistered = true;
		$this->repOk();
	}

	private function repOk() : void {
			assert($this->isRegistered == true);
			assert($this->username != NULL);
			assert($this->dbc->connected == 0);
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
