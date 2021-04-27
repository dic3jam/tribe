<?php 
declare(strict_types=1);
include 'trait/trait-authlogin.php';
include 'trait/trait-username.php';
include 'trait/trait-password.php';
include 'trait/trait-queryFunctions.php';
include 'trait/trait-messageBoardID.php';
include 'class-dbc.php';
/* class - User
 * Enables user access to tribe.com. 
 * Provides functions for edititng info, 
 * and displaying a profile page
 */
class user {
	use queryFunctions; 
	use authLogin;
	use password;
	use username;

	//admin
	private object $dbc;
	private array $auth;
	//User properties
	private string $username;
	private string $password;
	private string $firstName;
	private string $lastName;
	private string $password_creation_date;
	private string $user_creation_date;
	private string $pro_pic_loc;
	private string $about;
	private int $logins;
	private int $messageBoardID;
	private string $last_login_date;
	private array /*int*/ $tribe_memberships;

	//constructors

	public function __construct(array $queries){
		check_login();
		$this->userID = intval($_COOKIE['value']);
		//admin
		$this->dbc = new dbc($queries);
		//user properties
		$this->username = getUsername();
		$this->password = getPassword();
		$this->firstName = getFirstName();
		$this->lastName = getLastName();
		$this->password_creation_date = getPasswordCreateDate();
		$this->user_creation_date = getUserCreationDate();
		$this->pro_pic_loc = getProPic();
		$this->about = getAbout();
		updateLogins($this->userID);	
		$this->logins = getLogins();
		$this->messageBoardID = getMessageBoardID();
		$this->last_login_date = getLastLoginDate();
		$this->tribe_memberships = getAllTribalMemberships();
		repOk();
	}

	//repOK, toString

	private function repOk() : bool {
		assert($this->dbc->connect_errno == 0);
		assert(strlen($this->username) < 20); 
		assert(strlen($this->password) < 20);
		assert(strlen($this->firstName) < 20);
		assert(strlen($this->lastName) < 40);
		assert($this->paassword_creation_date != NULL);
		assert($this->user_creation_date != NULL);
		assert($this->pro_pic_loc != NULL);
		assert(strlen($this->about) >= 0 && strlen($this->about) <= 100);
		assert($this->logins >= 1);
		assert($this->messageBoarID != NULL);
		assert($this->last_login_date != NULL);
		assert(count($this->tribe_memberships) >= 0);
	}

	public function toString() : string {
		return  "Username: " . $this->username . 
			", firstName: " . $this->firstname .
			", lastName: " . $this->lastName .
			", password creation date: " . $this->password_creation_date .
			", user since: " . $this->user_creation_date .
			", profile pic: " . $this->pro_pic_loc .
			", logins: " . (strval($this->logins)) .
			", message board ID: " . (strval($this->messageBoardID)) .
			", last login date: " . $this->last_login_date . 
			", member of " . (strval(count(tribe_memberships))) . " tribes" .
			", about: " . $this->about .
			"DBC: " . $this->dbc->toString()
			;
	}

	//getters
	
	private function getProPic() : string {
		return queryFunctions::runQuery('getProPic', $this->dbc, 'i', " failed to get pro_pic_loc", $this->userID);
	}

	private function getAbout() : string {
		return queryFunctions::runQuery('getAbout', $this->dbc, 'i', " failed to get about", $this->userID);
	}
	
	private function getFirstName() : string {	
		return queryFunctions::runQuery('getFirstName', $this->dbc, 'i', " failed to get first name", $this->userID);
	}

	private function getLastName() : string {
		return queryFunctions::runQuery('getLastName', $this->dbc, 'i', " failed to get last name", $this->userID);
	}

	private function getLogins() : int {
		return queryFunctions::runQuery('getLogins', $this->dbc, 'i', " failed to get logins", $this->userID);
	}
	
	private function getAllTribalMemberships() : string {
		return queryFunctions::runQuery('getAllTribalMemberships', $this->dbc, 'i', " failed to get allTribalMemberships", $this->userID);
	}

	private function getLastLoginDate() : string {
		return queryFunctions::runQuery('getLastLoginDate', $this->dbc, 'i', " failed to get lastLoginDate", $this->userID);
	}

	private function getUserCreationDate() : string {	
		return queryFunctions::runQuery('getUserCreationDate', $this->dbc, 'i', " failed to get userCreationDate", $this->userID);
	}

	//setters
	
	//for adding to tribe, adding/removing council member status	
	//TODO see what the return array looks like for this
	private function modTribeMembership(int $tribeID, bool $isCouncilMember) : boolean {
		$result = NULL;
		$result = queryFunctions::runQuery('modTribeMembership', $this->dbc, 'iis', $this->userID, $tribeID, $isCouncilMember);	
		$this->tribe_memberships = getAllTribalMemberships();
		repOk();

	}

	private function setProPic() : bool {
		return queryFunctions::runQuery('setProPic', $this->dbc, 'si', " failed to set pro_pic_loc", $this->pro_pic_loc, $this->userID);
	}

	private function setAbout() : bool {
		return queryFunctions::runQuery('setAbout', $this->dbc, 'si', " failed to set about", $this->about, $this->userID);
	}

	private function setFirstName() : bool {
		return queryFunctions::runQuery('setFirstName', $this->dbc, 'si', " failed to set firstName", $this->firstName, $this->userID);
	}

	private function setLastName() : bool {
		return queryFunctions::runQuery('setLastName', $this->dbc, 'si', " failed to set firstName", $this->lastName, $this->userID);
	}

	//adds 1 to number of logins
	private function updateLogins(int $userID) : bool {
		return queryFunctions::runQuery('updateLogins', $this->dbc, 'i', " failed to update logins", $userID);
	}


	//$date must be in mysql datetime default format
	private function setLastLoginDate(string $date) : bool {
		return queryFunctions::runQuery('setLastLoginDate', $this->dbc, 'si', " failed to update last_login_date", $date, $this->userID);
	}

	private function setUserCreationDate() : bool {
		return queryFunctions::runQuery('setUserCreationDate', $this->dbc, 'i', " failed to update user_creation_date", $this->userID);
	}
}
 ?>
