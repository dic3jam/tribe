<?php 
declare(strict_types=1);
/* trait - queryFunctions
 * Encapsulates executing
 * MySQL Queries
 */
trait queryFunctions {

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
		$stmt = $dbc->prepare($dbc->queries[$q]);
		$stmt->bind_param($boundValueTypes, ...$params);
		$stmt->execute();
		//$stmt->bind_result($result);
		//$stmt->fetch();
		$initial_result = $stmt->get_result();
		$result = $initial_result->fetch_array();
		if($result == NULL) 
			throw new queryFailedException();
		if(count($result) == 2){ 
		//	if (str_contains($result[0], "row"))
		//		return true;
		//	else
				return $result[0];
		} else
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
	public function runQuery(string $q, object $dbc, string $boundValueTypes, string $errorMessage, ...$params) {
		try {
			return self::execQuery($q, $dbc, $boundValueTypes, ...$params);	
		} catch(Exception $e) {
			echo $e->getMessage() . $errorMessage;		
		}
	}

}
?>

