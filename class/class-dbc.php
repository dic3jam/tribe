<?php declare(strict_types=1);
require '../trait/trait-queries.php';
require 'Exceptions.php';
/* class-dbc
 * creates a mysqli database
 * connection
 */
class dbc extends mysqli {
	use query;

	private string $DB_NAME;
	private string $charset;
	private string $DB_USER;
	private string $DB_PASSWORD;
	private string $DB_HOST;
	public array $queries_array;
	private bool $connected;

	/* function dbc
	 * Constructs a database connection and 
	 * provides the interface for accessing database
	 * resources
	 * @throws RunTimeException if database connectio
	 * is unsuccessful
	 */
	public function __construct(){
		
		$DB_NAME = 'tribe';
		$charset = 'utf8';
		$DB_USER = 'root';
		$DB_PASSWORD = 'hIqBb6IMqdtO';
		$DB_HOST = '127.0.0.1';
		//$DB_USER = 'dic3jam';
		//$DB_PASSWORD = 'password';
		//$DB_HOST = 'localhost';
		parent::__construct($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
		$this->set_charset($charset);	
		$this->queries_array = query::$queries;
		try {
			if($this->connect_errno)
				throw new RuntimeException('mysqli connection error: ' . $this->connect_error);
			else
				$this->connected = true;
		} catch (Exception $e) {
			$errors[] = $e->getMessage();
			exit();
		}
		$this->repOk();
	}

	private function repOk() : void {
		try {
			assert($this->connected == true);
		} catch (Exception $e) {
			$errors[] = $e->getMessage();
			exit();
		}
	}

	public function toString() : string {
		return "DBC: " . $this->connected;
	}

	/* function runQuery
	 * used by the getters to funnel arguments to execQuery
	 * Performs the query bounding, execution, and returns the result
	 * @param string q - the name of SQL query to perform
	 * @param boundValueTypes - the string representing the types of the query items
	 * @param ...$params the query parameters
	 * @return true if there was no result expected back
	 * else if one result will return just that result
	 * else an associative array of the results
	 * @throws queryFailedException if the query fails
	 */
	public function runQuery(string $q, string $boundValueTypes, ...$params) /*: bool | array | string | int*/ { 
		$stmt = $this->prepare($this->queries_array[$q]);
		if(!$stmt)
			throw new queryFailedException("Query " . $q . " has improper syntax");
		//$this->mysqli_real_escape_string(...$params);
		$stmt->bind_param($boundValueTypes, ...$params);
		$stmt->execute();
		$initial_result = $stmt->get_result();
		if($initial_result == false)
			return true;
		$result = $initial_result->fetch_all();
		if(count($result[0]) == 1)
			return $result[0][0];
		else
			return $result;
	}

}
?>

