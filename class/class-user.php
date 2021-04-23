<?php 
declare(strict_types=1);
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
	private string $password_creation_date;
	private string $user_creation_date;
	private string $pro_pic_loc;
	private string $about;
	private int $logins;
	private int $messageBoarID;
	private string $last_login_date;
	private array /*int*/ $tribe_memberships;

	//constructors

	public function __construct(array $queries, object $dbc){
		check_login();
		$this->userID = intval($_COOKIE['value']);
		//admin
		$this->dbc = $dbc;
		$this->queries = $queries;
		//user properties
		$this->username = getUsername();
		$this->password = getPassword();
		$this->firstName = getFirstName();
		$this->lastName = getLastName();
		$this->paassword_creation_date = getPasswordCreateDate();
		$this->user_creation_date = getUserCreationDate();
		$this->pro_pic_loc = getProPic();
		$this->about = getAbout();
		$this->logins = getLogins();
		$this->messageBoarID = getMessageBoardID();
		$this->last_login_date = getLastLoginDate();
		$this->tribe_memberships = getAllTribalMemberships();
		repOk();
	}

	//repOK, toString

	private function repOk() : boolean {
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
			", about: " . $this->about
			;
	}
	
	//static functions

	/* function register
	 * Performs a user registration by sending new info
	 * to the database
	 * Note: Sanitizing user input is handled at the form
	 * @param string username - from $_POST
	 * @param string password - from $_POST
	 * @return boolean upon success
	 * @throws invalidPasswordException, invalidUserException, 
	 * passwordLengthException
	 */
	public static function register(string $username, string $password) : boolean{
		if(validPassword($password));
		else {
			throw new invalidPasswordException();
			return false;
		}
		if(validUsername($username));
		else{
			throw new invalidUserException();
			return false;
		}
		if(runQuery('createNewUser', 'ssssssi', " failed to create new user", 
			$username, 
			$password, 
			$_POST['firstName'].
			$_POST['lastName'],
			$_POST['pro_pic_loc'].
			$_POST['about'],
			$_POST['messageBoardID']))
		
			return true;
		else
			return false;

	}

	/* function login
	 * Completes a user login by checking username 
	 * and password and providing a login cookie
	 * @param string username - username from $_POST
	 * @param string password - password from $_POST
	 * @return boolean if login successful, constructs a login cookie
	 */
	public static function login(string $username, string $password) : boolean{
		$userID = getUserID($username);
		if(checkPassword($userID, $password)){
			createLoginToken($username, $userID);
			return true;
		} else 
			return false;
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
		$userID = getUserID($username);
		if(checkPassword($userID, $newPassword))
			return setPassword($newPassword, $userID);
		else
			return false;
	}

	//helpers

	/* function createLoginToken
	 * Generates the login cookie
	 * for a successful login
	 * @param string username
	 * @param int userID
	 * @return boolean indicating success
	 * note: for v1 all cookies are just userId and the "key"
	 */
	private function createLoginToken(string $username, int $userID) : boolean {
		return setcookie($username, strval($userID));	
	}

	/* function execQuery 
	 *  Performs the query bounding, execution, and returns the result
	 *  This function will only return queries of a singular result
	 *  @param string q - the query - always from the queries array
	 *  @param dbc - the database connection
	 *  @param boundValueTypes - the string representing the types of the query 
	 *  items
	 *  @return the result of the query (can be of any type)
	 *  @throws queryFailedException if the query fails
	 */
	private function execQuery(string $q, object $dbc, string $boundValueTypes, ...$params) {
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, $boundValueTypes, ...$params);
		$result = NULL;
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $result);
		mysqli_stmt_fetch($stmt);
		if($result == NULL || $result == false)
			throw new queryFailedException();
		else if (str_contains($result, "row"))
			return true;
		else
			return $result;
	}

	/* function runQuery
	 * used by the getters to funnel arguments to execQuery
	 * @param string q - the name of SQL query to perform
	 * @param boundValueTypes - the string representing the types of the query items
	 * @param errorMessage - the getter specific error message to be displayed if an 
	 * exception is thrown
	 * @return the result of the query (can be of any type)
	 */
	private function runQuery(string $q, string $boundValueTypes, string $errorMessage, ...$params) {
		try {
			return execQuery(queries[$q], $this->dbc, $boundValueTypes, ...$params);	
		} catch(Exception $e) {
			echo $e->getMessage() . $errorMessage;		
		}

	}

	//getters

	private function getUserID(string $username) : int {
		return runQuery('getUserID', 's', " failed to get userID", $username);
	}

	private function getProPic() : string {
		return runQuery('getProPic', 'i', " failed to get pro_pic_loc", $this->userID);
	}

	private function getAbout() : string {
		return runQuery('getAbout', 'i', " failed to get about", $this->userID);
	}

	private function getUsername() : string {
		return runQuery('getUsername', 'i', " failed to get username", $this->userID);
	}

	private function getPassword(int $userID) : string {
		return runQuery('getPassword', 'i', " failed to get password", $userID);
	}

	private function getFirstName() : string {	
		return runQuery('getFirstName', 'i', " failed to get first name", $this->userID);
	}

	private function getLastName() : string {
		return runQuery('getLastName', 'i', " failed to get last name", $this->userID);
	}

	private function getLogins() : int {
		return runQuery('getLogins', 'i', " failed to get logins", $this->userID);
	}

	private function getMessageBoardID() : int {		
		return runQuery('getMessageBoardID', 'i', " failed to get messageBoardID", $this->userID);
	}

	private function getPasswordCreateDate() : string {
		return runQuery('getPasswordCreatedate', 'i', " failed to get passwordCreateDate", $this->userID);
	}

	private function getAllTribalMemberships() : string {
		return runQuery('getAllTribalMemberships', 'i', " failed to get allTribalMemberships", $this->userID);
	}

	private function getLastLoginDate() : string {
		return runQuery('getLastLoginDate', 'i', " failed to get lastLoginDate", $this->userID);
	}

	private function getUserCreationDate() : string {	
		return runQuery('getUserCreationDate', 'i', " failed to get userCreationDate", $this->userID);
	}

	//setters

	private function setPassword(string $password, int $userid) : boolean {
		return runQuery('setPassword', 's', " failed to set new password", $userid);
	}

	//for adding to tribe, adding/removing council member status	
	//TODO see what the return array looks like for this
	private function modTribeMembership(int $tribeID, boolean $isCouncilMember) : boolean {
		$result = NULL;
		$result = runQuery('modTribeMembership','iis', $this->userID, $tribeID, $isCouncilMember);	
		$this->tribe_memberships = getAllTribalMemberships();
		repOk();

	}

	private function setProPic() : boolean {
		return runQuery('setProPic', 'si', " failed to set pro_pic_loc", $this->pro_pic_loc, $this->userID);
	}

	private function setAbout() : boolean {
		return runQuery('setAbout', 'si', " failed to set about", $this->about, $this->userID);
	}

	private function setFirstName() : boolean {
		return runQuery('setFirstName', 'si', " failed to set firstName", $this->firstName, $this->userID);
	}

	private function setLastName() : boolean {
		return runQuery('setLastName', 'si', " failed to set firstName", $this->lastName, $this->userID);
	}

	//adds 1 to number of logins
	private function updateLogins() : boolean {
		return runQuery('updateLogins', 'i', " failed to update logins", $this->userID);
	}

	private function setMessageBoardID() : boolean {
		return runQuery('setMessageBoardID', 'i', " failed to update logins", $this->userID);
	}

	private function setPasswordCreateDate() : boolean {
		return runQuery('setPasswordCreateDate', 'i', " failed to set passwordCreateDate", $this->userID);
	}

	private function setLastLoginDate() : boolean {
		return runQuery('setLastLoginDate', 'i', " failed to update last_login_date", $this->userID);
	}

	private function setUserCreationDate() : boolean {
		return runQuery('setUserCreationDate', 'i', " failed to update user_creation_date", $this->userID);
	}
}
 ?>
