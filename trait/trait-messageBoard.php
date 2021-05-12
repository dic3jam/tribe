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
	
	public function getTribeMessageBoardID(object $dbc, int $tribeID) : int {		
		return $dbc->runQuery('getTribeMessageBoardID', 'i', $tribeID);
	}

	public function createMessageBoardID(object $dbc, int $userID) : bool {
		return $dbc->runQuery('createMessageBoardID','i', $userID);
	}

	public function createTribeMessageBoardID(object $dbc, int $tribeID) : bool {
		return $dbc->runQuery('createTribeMessageBoardID','i', $tribeID);
	}

	public function sendPost(object $dbc, int $userID, string $message, int $messageBoardID) : bool {
		$ret = $dbc->runQuery('sendPost', 'is', $userID, $message);
		$pID = $dbc->runQuery('getPostID', 'is', $userID, $message);
		$ret &= $dbc->runQuery('updateMessageBoardPosts', 'ii', $messageBoardID, $pID);
		return (bool) $ret;
	}

	public function getAllPosts(object $dbc, int $messageBoardID) : array {
		return $dbc->runQuery('getAllPosts', 'i', $messageBoardID);
	}
}
?>
