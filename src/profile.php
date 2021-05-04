<?php
session_start();

$_SESSION['user'] = 1;

include '../class/class-user.php';
$error = array();
try {
    $user = new user();
} catch (Exception $e) {
    $error[] = $e->getMessage();
    if(!empty($_SESSION['user'])){
        session_unset();
        session_destroy();
    }
    header("Location: login.php");
    exit();
}
?>

<!---------HEADER---------------------->
<?php include '../include/header.php';?>
<!------------------------------------->
    <nav id='profile'>
        <h1>TRIBE</h1>
        <?php echo "<h1 class='title'>" . $user->firstName . " " . $user->lastName . "</h1>";?>
        <a class="navLink" href="edit-user.php">Edit Info</a>
        <?php include 'logout.php';?>
    </nav>
    </div> <!--header-->

    <div class='lsidebar'>
    <?php echo "<div class='list'>" . "<h3 class='listTitle'>" . "Tribal Memberships" . "</h3>";
    if(count($user->tribe_memberships) == 0) {
        echo "<h4>Tribe of One!</h4>";
        echo "<a href='create-tribe.php'>Create a new tribe!</a>";
    }
    for($i = 0; $i < count($user->tribe_memberships) ; $i++){
        $tribename = $user->tribe_memberships[$i][0];    
        $tribeID = $user->tribe_memberships[$i][1];    
        echo "<p class='listedLinks'><a href=tribe.php?tribeID=" . $tribeID ." >"  . $tribename . "</a></p>";       
    }
    echo "<a href='create-tribe.php'>Create a new tribe!</a>";
    echo "</div>";
    ?>
    </div><!--lsidebar-->

    <div class="main">
    <?php echo "<img class='pic' src=$user->pro_pic_loc alt='Unable to load image' width='300' height='400'>";?>
    <?php echo "<div class='about'>" . "<p class='aboutText'>" . $user->about . "</p>"  . "</div>";?>
    <?php echo "<div class='messageboard'>" . "<h3 class='messageboardTitle'>" . "Message Board" . "</h3>";
    echo "<p>Coming Soon!</p></div>";
    ?>
    </div><!--main-->
        
    <div class="footer">
<!---------Footer---------------------->
<?php include '../include/footer.php';?>
<!------------------------------------->
   