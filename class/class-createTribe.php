<?php
declare(strict_types=1);
include 'class-dbc.php';
include '../trait/trait-messageBoard.php';
include '../trait/trait-fileUpload.php';
include '../trait/trait-auth-login.php';
/* class - createTribe
 * Creates a new Tribe
 */
class createTribe {
  use authLogin;
	use messageBoard;
	use fileUpload;

  private bool $created;
  private string $newTribeName;
  private object $dbc;
  private int $tribeID;

  public function __construct() {
    authLogin::check_Login();
    $this->dbc = new dbc();
    $tribe_pic_loc = fileUpload::storeProPic();
    $this->newTribeName = (string)$_POST['newTribeName'];
    $this->dbc->runQuery('createNewTribe', 'ss', $this->newTribeName, $tribe_pic_loc);
    $this->tribeID = $this->dbc->runQuery('getTribeID', 's', $this->newTribeName);
    $this->dbc->runQuery('addTribeMembership', 'iii', intval($_SESSION['user']), $this->tribeID, 1);
		messageBoard::createTribeMessageBoardID($this->dbc, $this->tribeID);
    $this->created = true;
    $this->repOk();
  }

  private function repOk() : void {
    assert($this->createtd == true);
    assert($this->newTribeName != NULL);
    assert($this->dbc->connected == 0);
  }

  public function toString() : string {
      return "createTribe " .
             ", newTribeName " . $newTribeName .
             ", created " . $created .
             $this->dbc->toString()
             ;
  }

  public function advance() : bool {
      $this->repOk();
      $tribeURL = "tribe.php?tribeID=" . $this->tribeID;
      header("Location: " . $tribeURL);
      return true;
  }


}
?>