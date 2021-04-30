<?php 
declare(strict_types=1);
include '../trait/trait-ID.php';
include '../trait/trait-messageBoard.php';
include 'class-dbc.php';
include '../trait/trait-auth-login.php';
include '../trait/trait-username.php';
include '../trait/trait-fileUpload.php';
/* class - Tribe
 * Enables a tribe
 * page to display for
 * a user
 */
class tribe {
  use ID;
  use authLogin;
  use username;
  use messageBoard;
  use fileUpload;

  private object $dbc;
  public array $tribeMembers; //usernames, userIDs
  private int $tribeID;
  public string $tribeName;
  private bool $isCouncilMember;
  private int $userID;
  public string $tribe_pic_loc;
  public int $messageBoardID;

  public function __construct() {
    authLogin::check_login();
    $this->userID = intval($_SESSION['user']);
    $this->dbc = new dbc();
    $this->tribeID = (int) $_GET['tribeID'];
    //isCouncilMember failing will mean not a tribe member
    $this->isCouncilMember = $this->checkCouncilMember();
    $this->tribeName = $this->getTribeName();
    $this->tribeMembers = $this->getTribeMembers();
    $this->tribe_pic_loc = $this->getTribePic();
    $this->messageBoardID = messageBoard::getTribeMessageBoardID($this->dbc, $this->tribeID);
    $this->repOk();
  }

  private function repOk() : void {
		assert($this->dbc->connect_errno == 0);
    assert(count($this->tribeMembers) >= 0);
    assert($this->tribeID > 0);
    assert($this->tribeName != NULL);
    assert($this->userID > 0);
    assert($this->tribe_pic_loc != NULL);
    assert($this->messageBoardID > 0);
  }

  public function toString() : string {
    return "Tribe: " . $this->tribeName .
           ", TribeID: " . $this->tribeID .
           ", Current User: " . $this->userID .
           ", isCouncilMember " . $this->isCouncilMember .
           ", messageBoardID " . $this->messageBoardID .
           ", Members " . count($this->tribeMembers)
           ;
  }

  //getters

  /* private function valMember() : bool {
    $b = $this->dbc->runQuery("valMember", "ii", $this->tribeID, $this->userID);
    if($b != NULL)
      return true;
    else {
      throw new invalidMemberException();
      return false;
    }
  } */

  private function getTribePic() : string {
    return $this->dbc->runQuery("getTribePic", "i", $this->tribeID);
  }

  //running this also validates that they are a tribe member
  private function checkCouncilMember() : bool {
    $b = $this->dbc->runQuery("checkCouncilMember", "ii", $this->tribeID, $this->userID);
    if($b != NULL)
      return $b;
    else
      throw new invalidMemberException();
  }

  //@return array of usernames and userIDs
  private function getTribeMembers() : array {
    return $this->dbc->runQuery("getTribeMembers", "i", $this->tribeID);
  }

  private function getTribeName() : string {
    return $this->dbc->runQuery("getTribeName", "i", $this->tribeID);
  }

  //setters

  public function removeTribeMembership(string $username) : bool {
    try {
      $userID = ID::getUserID($username, $this->dbc);
      return $this->dbc->runQuery("removeTribeMembership", "ii", $this->tribeID, $userID);
    } catch (Exception $e) {
      $e->getMessage("User does not exist, or is not a member of this tribe");
    }
  }
  public function addTribeMembership(string $username, bool $isCouncilMember) : bool {
    try {
      $userID = ID::getUserID($username, $this->dbc);
    } catch (Exception $e) {
      $e->getMessage("Not a valid user");
    }
    return $this->dbc->runQuery("addTribeMembership", "iii", $userID, $this->tribeID, $isCouncilMember);
  }

  public function addCouncilMember(string $username) : bool {
    try {
      $userID = ID::getUserID($username, $this->dbc);
      return $this->dbc->runQuery("addCouncilMember", "ii", $this->tribeID, $userID);
    } catch (Exception $e) {
      $e->getMessage("Not a valid user, or not a member of this tribe");
    }
  }

  //TODO v2 removeCouncilMember (nned to be voted on)

  public function setTribePic(string $new_pic_loc) : bool {
    return $this->dbc->runQuery("setTribePic", "si", $new_pic_loc, $this->tribeID);
  }

  public function setTribeName(string $newTribeName) : bool {
    return $this->dbc->runQuery("setTribeName", "si", $newTribeName, $this->tribeID);
  }

}

 ?>
