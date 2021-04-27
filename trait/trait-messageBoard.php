<?php
declare(strict_types=1);
/* trait - messageBoard
 * functions for controlling
 * message boards
 */
trait messageBaord {
	use queryFunctions;

	public function getMessageBoardID(object $dbc) : int {		
		return queryFunctions::runQuery('getMessageBoardID', $dbc, 'i', " failed to get messageBoardID", $this->userID);
	}

	public function createMessageBoardID(object $dbc) : bool {
		return queryFunctions::runQuery('createMessageBoardID', $dbc,'i', " failed to create messageBoardID", $this->userID);
	}

}
?>
