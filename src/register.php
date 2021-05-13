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
            $reg->advance();
        } catch (Exception $e) {
			$error[] = $e->getMessage();
            foreach($_POST as $post)
                $post = '';
        }
    }
}
?>

<!---------HEADER---------------------->
<?php include '../include/header.php';?>
<!------------------------------------->
    <nav>
        <h1>TRIBE</h1>
        <h2>Register Here!</h2>
        <a href="login.php">Login</a>
    </nav>
    </div> <!--header-->

    <div class='formMain' id='regi'>
    <form method="post" enctype="multipart/form-data" id="reg">
        Username: <input type="text" name="username">
        Password: <input type="text" name="password">
        First Name: <input type="text" name="firstName">
        Last Name: <input type="text" name="lastName">
        Upload Profile Pic <input type="file" name="fileToUpload" id="fileToUpload">
        About: <textarea form="reg" maxlength="100" rows="5" cols="30" name="about">In 100 words or less</textarea>
        <input type="submit" name="Login">
    </form>
    <?php include 'errors.php';?>
    </div><!--main-->

    <div class="footer">
<!---------Footer---------------------->
<?php include '../include/footer.php';?>
<!------------------------------------->
 