<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(!empty($_POST['message'])) {
    if($user != NULL)
      messageBoard::sendPost($user->dbc, $user->userID, ((string)$_POST['message']), $user->messageBoardID);
    else
      messageBoard::sendPost($tribe->dbc, $tribe->tribeID, ((string)$_POST['message']), $tribe->messageBoardID);
      $_POST['message'] = '';
  }
}
?>
<form method='post' action='' onclick="addPost(document.getElementsByName('message')[0].value)" id='mb'>
   Message: <textarea form='mb' maxlength='500' rows='5' cols='30' name='message'></textarea>
   <input type='submit' name='Post'>
</form>