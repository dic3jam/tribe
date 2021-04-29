<?php
session_start();
//$_SESSION['user'] = 1;
include '../class/class-user.php';
$error = array();
try {
    $user = new user();
} catch (Exception $e) {
    $errors[] = "User invalid";
    if(!isset($_SESSION['user']))
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>TRIBE</title>
    </head>
    <body>
		<?php include '../include/header.php';?>

        <?php echo "<h1 class='name'>" . $user->firstName . " " . $user->lastName . "</h1>";?>

        //TODO logout button
        //TODO link to edit info

        <?php echo "<img class='propic' src=$user->pro_pic_loc alt='Unable to load image' width='300' height='400'>";?>

        <?php echo "<div class='about'>" . "<p class='aboutText'>" . $user->about . "</p>" . "</div>";?>

        <?php echo "<div class='tribeList'>" . "<h3 class='tribeListTitle'>" . "Tribal Memberships" . "</h3>";
        for($i = 0; $i < count($user->tribe_memberships) ; $i++){
            $tribename = $user->tribe_memberships[$i][0];    
            $tribeID = $user->tribe_memberships[$i][1];    
            echo "<p class='tribename'><a href='tribe.php?tribeID=" . $tribeID . "'>"  . $tribename . "</a></p>";       
        }
        echo "</div>";
        ?>

        <?php echo "<div class='messageboard'>" . "<h3 class='messageboardTitle'>" . "Message Board" . "</h3>";
        echo "<p>Coming Soon!</p></div>";
        ?>

        <?php include 'errors.php';?>
        <?php include '../include/footer.php';?>
    </body>
</html>
