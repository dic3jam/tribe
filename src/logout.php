<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['Logout'])){
        session_unset();
        session_destroy();
        header("Location: login.php");
    }
}

echo "<form method='post' action=''> 
  <input type='submit' name='Logout' value='Logout'>
</form>";

?>