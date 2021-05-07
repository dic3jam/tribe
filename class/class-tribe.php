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
  public bool $isCouncilMember;
  private int $userID;
  public string $username;
  public string $tribe_pic_loc;
  public int $messageBoardID;

  public function __construct() {
    authLogin::check_login();
    $this->userID = intval($_SESSION['user']);
    $this->dbc = new dbc();
    $this->tribeID = (int) $_GET['tribeID'];
    //isCouncilMember failing will mean not a tribe member
    $this->isCouncilMember = $this->checkCouncilMember($this->userID);
    $this->tribeName = $this->getTribeName();
    $this->tribeMembers = $this->getTribeMembers();
    $this->tribe_pic_loc = $this->getTribePic();
    $this->messageBoardID = messageBoard::getTribeMessageBoardID($this->dbc, $this->tribeID);
    $this->username = username::getUsername($this->userID, $this->dbc);
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
  private function checkCouncilMember(int $userID) : bool {
    $b = $this->dbc->runQuery("checkCouncilMember", "ii", $this->tribeID, $userID);
    if($b == 1)
      return true;
    else if($b == 0)
      return false;
    else
      throw new invalidMemberException("Not a member of this tribe");
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
      $userID = ID::getUserID($username, $this->dbc);
      if(!$this->valMember($username))
        throw new invalidMemberException("User is not a member of this tribe");
      else{
        $this->removeFromMemberArray($username);
        return $this->dbc->runQuery("removeTribeMembership", "ii", $userID, $this->tribeID);
      }
  }

  public function addTribeMembership(string $username, bool $isCouncilMember) : bool {
      $userID = ID::getUserID($username, $this->dbc);
      if($this->valMember($username)) 
        throw new invalidMemberException("User is already a tribe member!");
      else
        return $this->dbc->runQuery("addTribeMembership", "iii", $userID, $this->tribeID, $isCouncilMember);
  }

  public function addCouncilMember(string $username) : bool {
    $userID = ID::getUserID($username, $this->dbc);
    if(!$this->valMember($username))
        throw new invalidMemberException("User is not a member of this tribe");
    if($this->checkCouncilMember($userID))
      throw new invalidMemberException("Already a council member!");
      else
        return $this->dbc->runQuery("addCouncilMember", "ii", $this->tribeID, $userID);
  }

  //TODO v2 removeCouncilMember (nned to be voted on)

  public function setTribePic(string $new_pic_loc) : bool {
    return $this->dbc->runQuery("setTribePic", "si", $new_pic_loc, $this->tribeID);
  }

  public function setTribeName(string $newTribeName) : bool {
    return $this->dbc->runQuery("setTribeName", "si", $newTribeName, $this->tribeID);
  }

  private function valMember(string $username) : bool {
    for($i = 0; $i<count($this->tribeMembers); $i++) {
        if($this->tribeMembers[$i][0] == $username)
          return true;
      }
      return false;
  }

  private function removeFromMemberArray(string $username) : bool {
    for($i = 0; $i<count($this->tribeMembers); $i++) {
        if($this->tribeMembers[$i][0] == $username)
          $this->tribeMembers[$i][0] == $username . " removed";
          $this->tribeMembers[$i][1] == NULL;
          return true;
      }
      return false;
  }
}

 ?>
