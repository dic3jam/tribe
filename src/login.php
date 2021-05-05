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
				if(isset($_SESSION['user']))
					session_unset();
					session_destroy();
					header("Location: login.php");
					$_POST['username'] = '';
					$_POST['password'] = '';
		}
	}else {
		$error[] = "<p>Bad login attempt</p>";
		$_POST['username'] = '';
		$_POST['password'] = '';
	}
}
?>
<!---------HEADER---------------------->
<?php include '../include/header.php';?>
<!------------------------------------->
		<h1>TRIBE</h1>
		<h2>Building Communities of Trust and Respect</h2>
    </div> <!--header-->

    <div class='formMain' id='login'>
		<h3>Login Here</h3>
		<form method="post" action=""> 
			Username: <input type="text" name="username">
			Password: <input type="text" name="password">
			<input type="submit" name="Login">
		</form>
		<?php include 'errors.php';?>
		<a href="register.php">New? JOIN THE TRIBE</a>
		<a href="change-password.php">Change Password</a>
		<a href="beatRubric.php">CCV1152 Beat the Rubric Here!</a>
    </div><!--main-->
   
    <div class="footer">
<!---------Footer---------------------->
<?php include '../include/footer.php';?>
<!------------------------------------->
 

