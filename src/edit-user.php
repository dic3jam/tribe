<?php
session_start();
include '../class/class-user.php';
include '../trait/trait-fileUpload.php';
use fileUpload;
$error = array();
try {
    $user = new user();
} catch (Exception $e) {
    $error[] = $e->getMessage();
    if(!isset($_SESSION['user'])){
        session_unset();
        session_destroy();
    }
    header("Location: login.php");
    exit();
}
$actions = array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try {
        if(isset($_POST['username']) && !empty($_POST['username'])){
            username::setUsername(((string)$_POST['username']), $user->userID, $user->dbc);        
            $actions[] = "Username updated";
            $_POST['username'] = '';
        }
        if(isset($_POST['password']) && !empty($_POST['password'])) {
            password::changePasswordEditUser($user->username, ((string)$_POST['password']), $user->userID, $user->dbc);        
            $actions[] = "Password updated";
            $_POST['password'] = '';
        }
        if(isset($_POST['firstName']) && !empty($_POST['firstName'])){
            $user->setFirstName(((string)$_POST['firstName']));        
            $actions[] = "First Name updated";
            $_POST['firstName'] = '';
        }
        if(isset($_POST['lastName']) && !empty($_POST['lastName'])){
            $user->setLastName(((string)$_POST['lastName']));        
            $actions[] = "Last Name updated";
            $_POST['lastName'] = '';
        }
        if(isset($_POST['about']) && !empty($_POST['about'])){
            $user->setAbout(((string)$_POST['about']));        
            $actions[] = "About updated";
            $_POST['about'] = '';
        }
        if($_FILES['fileToUpload']['error'] != 4) {
            fileUpload::delProPic($user->pro_pic_loc);
            $user->setProPic(fileUpload::storeProPic());
            $actions[] = "Pro pic uploaded successfully";
            //TODO does this make an entry in $_POST? If so need to clear
        }
    } catch (Exception $e) {
        $error[] = $e->getMessage();
    }
}
?>
<!---------HEADER---------------------->
<?php include '../include/header.php';?>
<!------------------------------------->

    <nav id='editUser'>
        <h1>TRIBE</h1>
        <h2>EDIT USER</h2>
        <a id="return" href="profile.php"><?php echo $user->username?></a>
        <?php include 'logout.php';?>
    </nav>
    </div> <!--header-->

    <div class='main'>
    <form method="post" action="" enctype="multipart/form-data">
        Username: <input type="text" name="username">
        Password: <input type="text" name="password">
        First Name: <input type="text" name="firstName">
        Last Name: <input type="text" name="lastName">
        Upload Profile Pic <input type="file" name="fileToUpload" id="fileToUpload">
        About: <input type="text" name="about">
        <input type="submit" name="Login">
    </form>
    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($actions) && !empty($actions)){
            foreach($actions as $a){
                    echo "<p class='actions'>" . $a . "</p>";
            }	
        }
    }
    ?>
    <?php include 'errors.php';?>
    </div><!--main-->

    <div class="footer">
<!---------Footer---------------------->
<?php include '../include/footer.php';?>
<!------------------------------------->
