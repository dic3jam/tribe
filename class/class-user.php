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
	private string $password_creation_date;
	private string $user_creation_date;
	private string $pro_pic_loc;
	private string $about;
	private int $logins;
	private int $messageBoarID;
	private string $last_login_date;
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
	public static function register() : boolean{

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

	//helpers

	/* function createLoginCookie
	 * Generates the login cookie
	 * for a successful login
	 * @param int userID
	 * @return boolean indicating success
	 * note: for v1 all cookies are just userId and the "key"
	 */
	private function createLoginCookie(int $userID) : boolean {}

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
	private function execQuery(string $q, object $dbc, string $boundValueTypes, 
			 ...$params) {
		mysqli_stmt_bind_param($stmt, $boundValueTypes, ...$params);
		$result = NULL;
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $result);
		mysqli_stmt_fetch($stmt);
		if($result == NULL)
			throw new queryFailedException();
		else
			return $result;
	}

	/* function prepQuery
	 * used by the getters to funnel arguments to execQuery
	 * @param string q - the name of SQL query to perform
	 * @param boundValueTypes - the string representing the types of the query items
	 * @param errorMessage - the getter specific error message to be displayed if an 
	 * exception is thrown
	 * @return the result of the query (can be of any type)
	 */
	private function prepQuery(string $q, string $boundValueTypes, string $errorMessage, ...$params) {
		try {
			return execQuery(queries[$q], $this->dbc, $boundValueTypes, ...$params);	
		} catch(Exception $e) {
			echo $e->getMessage() . $boundValueTypes;		
		}

	}

	//getters

	private function getProPic() : string {
		return preqQuery('getProPic', 'i', " failed to get pro_pic_loc", $this->userID);
	}

	private function getAbout() : string {
		return preqQuery('getAbout', 'i', " failed to get about", $this->userID);
	}

	private function getUsername() : string {
		return preqQuery('getUsername', 'i', " failed to get username", $this->userID);
	}

	private function getPassword() : string {
		return preqQuery('getPassword', 'i', " failed to get password", $this->userID);
	}

	private function getFirstName() : string {	
		return preqQuery('getFirstName', 'i', " failed to get first name", $this->userID);
	}

	private function getLastName() : string {
		return preqQuery('getLastName', 'i', " failed to get last name", $this->userID);
	}

	private function getLogins() : int {
		return preqQuery('getLogins', 'i', " failed to get logins", $this->userID);
	}

	private function getMessageBoardID() : int {		
		return preqQuery('getMessageBoardID', 'i', " failed to get messageBoardID", $this->userID);
	}

	private function getPasswordCreateDate() : string {
		return preqQuery('getPasswordCreatedate', 'i', " failed to get passwordCreateDate", $this->userID);
	}

	private function getAllTribalMemberships() : string {
		return preqQuery('getAllTribalMemberships', 'i', " failed to get allTribalMemberships", $this->userID);
	}

	private function getLastLoginDate() : string {
		return preqQuery('getLastLoginDate', 'i', " failed to get lastLoginDate", $this->userID);
	}

	private function getUserCreationDate() : string {	
		return preqQuery('getUserCreationDate', 'i', " failed to get userCreationDate", $this->userID);
	}

	//setters

	//for adding to tribe, adding/removing council member status	
	//TODO see what the return array looks like for this
	private function modTribeMembership(int $tribeID, boolean $isCouncilMember) : boolean {
		$result = NULL;
		$result = prepQuery('modTribeMembership','iis', $this->userID, $tribeID, $isCouncilMember);	
		$this->tribe_memberships = getAllTribalMemberships();
		repOk();

	}

	private function setProPic() : boolean {
	
	}

	private function setAbout() : boolean {}

	private function setFirstName() : boolean {}

	private function setLastName() : boolean {}

	private function updateLogins() : boolean {}

	private function setMessageBoardID() : boolean {}

	private function setPasswordCreateDate() : boolean {}

	private function setLastLoginDate() : boolean {}

	private function setUserCreationDate() : boolean {}
}
 ?>
