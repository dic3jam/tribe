<?php
session_start();

include '../class/class-createTribe.php';
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
        $error[] = "You must upload a tribe picture"; 
    }   
    if($varSet){
        try {
            $newTribe = new createTribe();
            $newTribe->advance();
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

    <nav id='createTribe'>
        <h1>TRIBE</h1>
        <h2>Create a New Tribe</h2>
        <a id="return" href="profile.php">Return to Profile</a>
        <?php include 'logout.php';?>
    </nav>
    </div> <!--header-->

    <div class="formMain">
    <h2>Create New Tribe!</h2>
    <form method="post" action="" enctype="multipart/form-data">
        TribeName: <input type="text" name="newTribeName">
        Upload Tribe Pic <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" name="Login">
    </form>
    <?php include 'errors.php';?>
    </div> <!--main-->

    <div class="footer">
<!---------Footer---------------------->
<?php include '../include/footer.php';?>
<!------------------------------------->
 