<?php 
include 'class/class-login.php';
include 'include/queries.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(!empty($_POST['username']) && !empty($_POST['password'])){
		try {
			$user = new login((string)$_POST['username'], (string)$_POST['password'], $queries);
			echo $user->toString();
		} catch (Exception $e) {
			$e->getMessage();
			header("Location: login.php");
		}
		$user->advance();
	}else
		echo "<p>Bad login attempt</p>";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>TRIBE</title>
    </head>
    <?php include 'include/header.php';
    ?>
    <body>
        <h1>TRIBE</h1>
        <h2>Building Communities of Trust and Respect</h2>
	<h3>Login Here</h3>
	<form method="post" action=""> 
	   Username: <input type="text" name="username">
	   Password: <input type="text" name="password">
	   <input type="submit" name="Login">
        </form>
        <a href="register.php">New? JOIN THE TRIBE</a>
        <a href="change-password.php">Change Password</a>
    <?php include 'include/footer.php';?>
    </body>
</html>


