<?php 
include '../class/class-register.php';
$error = array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $varSet = true;
    foreach($_POST as $key=>$value) {
        if($value == '') {
            $varSet = false;
            $error[] = $key . " is not set";
        }
    }
    if($_FILES['fileToUpload']['error'] == 4){
        $varSet = false;
        $error[] = "You must upload a profile picture";
    }
    if($varSet){
        try {
            $reg = new register();
            echo $reg->toString();
            $reg->advance();
        } catch (Exception $e) {
			$error[] = $e->getMessage();
            foreach($_POST as $post)
                $post = '';
        }
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
        <h2>Register Here!</h2>
        <form method="post" action="" enctype="multipart/form-data">
            Username: <input type="text" name="username">
			Password: <input type="text" name="password">
            First Name: <input type="text" name="firstName">
            Last Name: <input type="text" name="lastName">
            Upload Profile Pic <input type="file" name="fileToUpload" id="fileToUpload">
            About: <input type="text" name="about">
			<input type="submit" name="Login">
        </form>
		<?php include 'errors.php';?>
        <?php include '../include/footer.php';?>
    </body>
</html>