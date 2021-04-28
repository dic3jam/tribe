<?php
declare(strict_types=1);
/* trait - userID
 * enables multiple classes
 * to access the getUserID function
 */
trait ID {

	public function getUserID(string $username, object $dbc) : int {
		return $dbc->runQuery('getUserID','s', $username);

	}
}
?>
