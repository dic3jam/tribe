<?php 
declare(strict_types=1);
include '../trait/trait-auth-login.php';
include '../trait/trait-username.php';
include '../trait/trait-password.php';
include '../trait/trait-ID.php';
include '../trait/trait-messageBoard.php';
include 'class-dbc.php';
//require 'Exceptions.php';
/* class - User
 * Enables user access to tribe.com. 
 * Provides functions for edititng info, 
 * and displaying a profile page
 */
class user {
	use ID; 
	use authLogin;
	use password;
	use username;
	use messageBoard;

	//admin
	public object $dbc;
	//User properties
	public int $userID;
	public string $username;
	private string $password;
	public string $firstName;
	public string $lastName;
	private string $password_creation_date;
	private string $user_creation_date;
	public string $pro_pic_loc;
	public string $about;
	private int $logins;
	public int $messageBoardID;
	private string $last_login_date;
	public array /*associative*/ $tribe_memberships;

	//constructors

	public function __construct(){
		authLogin::check_login();
		$this->userID = intval($_SESSION['user']);
		//admin
		$this->dbc = new dbc();
		//user properties
		$this->username = username::getUsername($this->userID, $this->dbc);
		$this->password = password::getPassword($this->userID, $this->dbc);
		$this->firstName = $this->getFirstName();
		$this->lastName = $this->getLastName();
		$this->password_creation_date = password::getPasswordCreateDate($this->userID, $this->dbc);
		$this->user_creation_date = $this->getUserCreationDate();
		$this->pro_pic_loc = $this->getProPic();
		$this->about = $this->getAbout();
		$this->logins = $this->getLogins();
		$this->messageBoardID = messageBoard::getMessageBoardID($this->dbc, $this->userID);
		$this->last_login_date = $this->getLastLoginDate();
		$this->tribe_memberships = $this->getAllTribalMemberships();
		$this->repOk();
	}

	//repOK, toString

	private function repOk() : void {
		assert($this->dbc->connect_errno == 0);
		assert(strlen($this->username) < 20); 
		assert(strlen($this->password) < 40);
		assert(strlen($this->firstName) < 20);
		assert(strlen($this->lastName) < 40);
		assert($this->password_creation_date != NULL);
		assert($this->user_creation_date != NULL);
		assert($this->pro_pic_loc != NULL);
		assert(strlen($this->about) >= 0 && strlen($this->about) <= 100);
		assert($this->logins >= 1);
		assert($this->messageBoardID != NULL);
		assert($this->last_login_date != NULL);
		assert(count($this->tribe_memberships) >= 0);
	}

	public function toString() : string {
		return  "Username: " . $this->username . 
			", firstName: " . $this->firstname .
			", lastName: " . $this->lastName .
			", password creation date: " . $this->password_creation_date .
			", user since: " . $this->user_creation_date .
			", logins: " . (strval($this->logins)) .
			", message board ID: " . (strval($this->messageBoardID)) .
			", last login date: " . $this->last_login_date . 
			", member of " . (strval(count(tribe_memberships))) . " tribes" .
			", about: " . $this->about .
			$this->dbc->toString()
			;
	}

	//getters
	
	private function getProPic() : string {
		return $this->dbc->runQuery('getProPic', 'i', $this->userID);
	}

	private function getAbout() : string {
		return $this->dbc->runQuery('getAbout', 'i', $this->userID);
	}
	
	private function getFirstName() : string {	
		return $this->dbc->runQuery('getFirstName', 'i', $this->userID);
	}

	private function getLastName() : string {
		return $this->dbc->runQuery('getLastName', 'i', $this->userID);
	}

	private function getLogins() : int {
		return $this->dbc->runQuery('getLogins', 'i', $this->userID);
	}
	
	private function getAllTribalMemberships() : array {
		return $this->dbc->runQuery('getAllTribalMemberships', 'i', $this->userID);
	}

	private function getLastLoginDate() : string {
		return $this->dbc->runQuery('getLastLoginDate', 'i', $this->userID);
	}

	private function getUserCreationDate() : string {	
		return $this->dbc->runQuery('getUserCreationDate', 'i', $this->userID);
	}

	//setters
	
	//for adding to tribe, adding/removing council member status	
	//TODO see what the return array looks like for this
	public function modTribeMembership(int $tribeID, bool $isCouncilMember) : boolean {
		$result = $this->dbc->runQuery('modTribeMembership', 'iis', $this->userID, $tribeID, $isCouncilMember);	
		$this->tribe_memberships = getAllTribalMemberships();
		$this->repOk();
	}

	public function setProPic(string $pro_pic_loc) : bool {
		return $this->dbc->runQuery('setProPic', 'si', $pro_pic_loc, $this->userID);
	}

	public function setAbout(string $about) : bool {
		return $this->dbc->runQuery('setAbout', 'si', $about, $this->userID);
	}

	public function setFirstName(string $firstName) : bool {
		return $this->dbc->runQuery('setFirstName', 'si', $firstName, $this->userID);
	}

	public function setLastName(string $lastName) : bool {
		return $this->dbc->runQuery('setLastName', 'si', $lastName, $this->userID);
	}

	//$date must be in mysql datetime default format
	public function setLastLoginDate(string $date) : bool {
		return $this->dbc->runQuery('setLastLoginDate', 'si', $date, $this->userID);
	}

	public function setUserCreationDate() : bool {
		return $this->dbc->runQuery('setUserCreationDate', 'i', $this->userID);
	}
}
 ?>
