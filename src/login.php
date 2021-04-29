<?php declare(strict_types=1);
session_start();
include '../class/class-login.php';
$error = array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(!empty($_POST['username']) && !empty($_POST['password'])){
		try {
			$user = new login((string)$_POST['username'], (string)$_POST['password']);
			$user->advance();
		} catch (Exception $e) {
				$error[] = $e->getMessage();
				if(isset($_COOKIE['value']))
					$user->createLoginToken($this->userID);
					$_POST['username'] = '';
					$_POST['password'] = '';
					//header("Location: login.php");
		}
	}else {
		$error[] = "<p>Bad login attempt</p>";
		$_POST['username'] = '';
		$_POST['password'] = '';
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
			<title>TRIBE</title>
	</head>
  <body>
		<?php include '../include/header.php';?>
		<h1>TRIBE</h1>
		<h2>Building Communities of Trust and Respect</h2>
		<h3>Login Here</h3>
		<form method="post" action=""> 
			Username: <input type="text" name="username">
			Password: <input type="text" name="password">
			<input type="submit" name="Login">
		</form>
		<?php include 'errors.php';?>
        <a href="register.php">New? JOIN THE TRIBE</a>
        <a href="change-password.php">Change Password</a>
    <?php include '../include/footer.php';?>
    </body>
</html>


