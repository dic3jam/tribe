<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(!empty($_POST['message'])) {
    if(isset($user)) {
      messageBoard::sendPost($user->dbc, $user->userID, ((string)$_POST['message']), $user->messageBoardID);
    }else {
      messageBoard::sendPost($tribe->dbc, ((int)$_SESSION['user']), ((string)$_POST['message']), $tribe->messageBoardID);
    }
    $_POST['message'] = '';
  }
}
?>
<form method='post' id='mb_send'>
   Message: <textarea form='mb_send' maxlength='500' rows='5' cols='30' name='message'></textarea>
   <input type='submit' name='Post'>
</form>