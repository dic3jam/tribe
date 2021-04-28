<?php
declare(strict_types=1);
/* trait - messageBoard
 * functions for controlling
 * message boards
 */
trait messageBoard {

	public function getMessageBoardID(object $dbc, int $userID) : int {		
		return $dbc->runQuery('getMessageBoardID', 'i', $userID);
	}

	public function createMessageBoardID(object $dbc, int $userID) : bool {
		return $dbc->runQuery('createMessageBoardID','i', $userID);
	}

}
?>
