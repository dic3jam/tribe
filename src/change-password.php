<?php 
include '../trait/trait-password.php';
include '../trait/trait-ID.php';
include '../class/class-dbc.php';
use password;
use ID;
$error = array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $varSet = true;
    foreach($_POST as $key=>$value) {
        if($value == '') {
            $varSet = false;
            $error[] = $key . " is not set";
        }
    }
    if($varSet){
        try{
            $dbc = new dbc();
            password::changePassword(((string)$_POST['username']), ((string)$_POST['password']), ((string)$_POST['newPassword']), $dbc);
            header("Location: login.php");
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
    <h1>TRIBE</h1>
    <h2>Change Password</h2>
    </div> <!--header-->

    <div class='main'>
    <form method="post" action="">
        Username: <input type="text" name="username">
        Password: <input type="text" name="password">
        New Password: <input type="text" name="newPassword">
        <input type="submit" name="Login">
    </form>
    <?php include 'errors.php';?>
    </div><!--main-->

    <div class="footer">
<!---------Footer---------------------->
<?php include '../include/footer.php';?>
<!------------------------------------->
 
