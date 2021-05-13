<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['Logout'])){
        session_unset();
        session_destroy();
        header("Location: login.php");
    }
}?>
<form method='post'> 
  <input id='logout' type='submit' name='Logout' value='Logout'>
</form>
