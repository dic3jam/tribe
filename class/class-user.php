<?php 
declare(strict_types=1);
include 'trait/trait-authlogin.php';
include 'trait/trait-username.php';
include 'trait/trait-password.php';
include 'trait/trait-userID.php';
include 'trait/trait-messageBoard.php';
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

	public function __construct(){
		try {
			check_login();
			$this->userID = intval($_COOKIE['value']);
			//admin
			$this->dbc = new dbc();
			//user properties
			$this->username = username::getUsername();
			$this->password = password::getPassword();
			$this->firstName = getFirstName();
			$this->lastName = getLastName();
			$this->password_creation_date = password::getPasswordCreateDate();
			$this->user_creation_date = getUserCreationDate();
			$this->pro_pic_loc = getProPic();
			$this->about = getAbout();
			updateLogins($this->userID);	
			$this->logins = getLogins();
			$this->messageBoardID = messageBoardgetMessageBoardID();
			$this->last_login_date = getLastLoginDate();
			$this->tribe_memberships = getAllTribalMemberships();
		} catch (Exception $e) {
				$errors[] = "User invalid";
				if(isset($_COOKIE['value']))
					$this->createLoginToken($this->username, $this->userID, -3600);
				header("Location: login.php");
				exit();
		}
		$this->repOk();
	}

	//repOK, toString

	private function repOk() : void {
		try {
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
		} catch (Exception $e) {
				if(isset($_COOKIE['value']))
					$this->createLoginToken($this->username, $this->userID, -3600);
				header("Location: login.php");
				exit();
		}
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
		return $this->dbc->runQuery('getLastName', 'i', " failed to get last name", $this->userID);
	}

	private function getLogins() : int {
		return $this->dbc->runQuery('getLogins', 'i', " failed to get logins", $this->userID);
	}
	
	private function getAllTribalMemberships() : string {
		return $this->dbc->runQuery('getAllTribalMemberships', 'i', " failed to get allTribalMemberships", $this->userID);
	}

	private function getLastLoginDate() : string {
		return $this->dbc->runQuery('getLastLoginDate', 'i', " failed to get lastLoginDate", $this->userID);
	}

	private function getUserCreationDate() : string {	
		return $this->dbc->runQuery('getUserCreationDate', 'i', " failed to get userCreationDate", $this->userID);
	}

	//setters
	
	//for adding to tribe, adding/removing council member status	
	//TODO see what the return array looks like for this
	private function modTribeMembership(int $tribeID, bool $isCouncilMember) : boolean {
		$result = NULL;
		$result = $this->dbc->runQuery('modTribeMembership', 'iis', $this->userID, $tribeID, $isCouncilMember);	
		$this->tribe_memberships = getAllTribalMemberships();
		$this->repOk();

	}

	private function setProPic() : bool {
		return $this->dbc->runQuery('setProPic', 'si', " failed to set pro_pic_loc", $this->pro_pic_loc, $this->userID);
	}

	private function setAbout() : bool {
		return $this->dbc->runQuery('setAbout', 'si', " failed to set about", $this->about, $this->userID);
	}

	private function setFirstName() : bool {
		return $this->dbc->runQuery('setFirstName', 'si', " failed to set firstName", $this->firstName, $this->userID);
	}

	private function setLastName() : bool {
		return $this->dbc->runQuery('setLastName', 'si', " failed to set firstName", $this->lastName, $this->userID);
	}

	//adds 1 to number of logins
	private function updateLogins(int $userID) : bool {
		return $this->dbc->runQuery('updateLogins', 'i', " failed to update logins", $userID);
	}


	//$date must be in mysql datetime default format
	private function setLastLoginDate(string $date) : bool {
		return $this->dbc->runQuery('setLastLoginDate', 'si', " failed to update last_login_date", $date, $this->userID);
	}

	private function setUserCreationDate() : bool {
		return $this->dbc->runQuery('setUserCreationDate', 'i', " failed to update user_creation_date", $this->userID);
	}
}
 ?>
