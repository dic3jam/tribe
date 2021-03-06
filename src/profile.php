<?php
session_start();

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
    <script>var exports = {};</script>
    <script src='../js/messageboard.js'></script>
    <script>
        var xhr = new XMLHttpRequest();
        var url = "../src/get_messages.php?messageBoardID=<?php echo $user->messageBoardID?>";
        if(document.readyState !== 'loading') {
        xhrOpen(xhr, url);
        } else { 
        document.addEventListener('DOMContentLoaded', (event) => {
            xhrOpen(xhr, url);
        });
        }
        xhr.onreadystatechange = () => {
        if (xhr.readyState == 4) {
            let new_messages = JSON.parse(xhr.response);
            addPost(new_messages, 0, document.getElementById('mb'));
        }
        }; 
    </script>
    <nav id='profile'>
        <h1>TRIBE</h1>
        <?php echo "<h2 class='title'>" . $user->firstName . " " . $user->lastName . "</h2>";?>
        <a class="navLink" href="edit-user.php">Edit Info</a>
        <?php include 'logout.php';?>
    </nav>
    </div> <!--header-->

    <div class='lsidebar'>
    <?php echo "<div class='list'>" . "<h3 class='listTitle'>" . "Tribal Memberships" . "</h3>";
    if(count($user->tribe_memberships) == 0) {
        echo "<h4>Tribe of One!</h4>";
    }else {
        echo "<ul>";
        for($i = 0; $i < count($user->tribe_memberships) ; $i++){
            $tribename = $user->tribe_memberships[$i][0];    
            $tribeID = $user->tribe_memberships[$i][1];    
            echo "<li><a href=tribe.php?tribeID=" . $tribeID ." >"  . $tribename . "</a></li>";       
        }
    }
    echo "<li><a href='create-tribe.php'>Create a new tribe!</a></li>";
    echo "</ul></div>";
    ?>
    </div><!--lsidebar-->

    <div class="main">
        <div class='leftMain'>
            <div class="imgBox">
                <?php echo "<img src=$user->pro_pic_loc alt='Unable to load image'>";?>
            </div><!--imgBox-->
            <div class='about'>
            <h3>About</h3>
            <?php echo "<p class='aboutText'>" . $user->about . "</p>";?> 
            </div><!--about-->
        </div><!--leftMain-->
        <div class='rightMain'>
            <div class='messageboard'>
               <h3>Message Board</h3>
                  <?php include '../include/messageBoard.php';?>
                  <div id='mb'></div>
            </div><!--messageboard-->
        </div><!--rightMain-->
    </div><!--main-->
        
    <div class="footer">
<!---------Footer---------------------->
<?php include '../include/footer.php';?>
<!------------------------------------->
   
