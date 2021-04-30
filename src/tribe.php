<?php
session_start();
include '../class/class-tribe.php';
try {
    $tribe = new tribe();
} catch (Exception $e) {
    $error[] = $e->getMessage();
    if(!empty($_SESSION['user'])){
        session_unset();
        session_destroy();
    }
    header("Location: login.php");
    exit();
}
$actions = array();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if(isset($_POST['invite']) && !empty($_POST['invite'])){
            $tribe->addTribeMembership(((string)$_POST['invite']), 0);
            $actions[] = "Member added";
            $_POST['invite'] = '';
        }
        if(isset($_POST['remove']) && !empty($_POST['remove'])){
            $tribe->removeTribeMembership(((string)$_POST['remove']));
            $actions[] = "Member removed";
            $_POST['remove'] = '';
        }
        if(isset($_POST['council']) && !empty($_POST['council'])){
            $tribe->addCouncilMember(((string)$_POST['council']));
            $actions[] = "Council member added";
            $_POST['council'] = '';
        }
        if($_FILES['fileToUpload']['error'] != 4) {
            fileUpload::delProPic($tribe->tribe_pic_loc);
            $tribe->setTribePic(fileUpload::storeProPic());
            $actions[] = "Tribe pic uploaded successfully";
            //TODO does this make an entry in $_POST? If so need to clear
        }
    } catch (Exception $e) {
        $error[] = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>TRIBE</title>
    </head>
    <body>
        <?php include 'errors.php';?>
        <?php include '../include/header.php';?>

        <h1 class='tribeTitle'><?php echo $tribe->tribeName?></h1>

        <a id="return" href="profile.php">Return to Profile</a>

        <?php echo "<img class='tribepic' src=$tribe->tribe_pic_loc alt='Unable to load image' width='300' height='400'>";?>

        <?php echo "<div class='memberList'>" . "<h3 class='MemberListTitle'>" . "Tribal Members" . "</h3>";
                for($i = 0; $i < count($tribe->tribeMembers) ; $i++){
                    $username = $tribe->tribeMembers[$i][0];    
                    $userID = $tribe->tribeMembers[$i][1];    
                    echo "<p class='username'><a href='profile.php?userID=" . $userID . "'>"  . $username . "</a></p>";       
                }
        ?>

        <?php echo "<div class='messageboard'>" . "<h3 class='messageboardTitle'>" . $tribe->tribeName ." Board" . "</h3>";
        echo "<p>Coming Soon!</p></div>";
        ?>

        <?php if($tribe->isCouncilMember) {
            echo "<div class='councilDiv'>";
            echo "<h2 class='councilForm'>" . "Council Member Table" . "</h2>";
            echo "<form class='councilForm' method='post' action='' enctype='multipart/form-data>" .
            "Invite Members: <input type='text' name='invite'>" . 
            "Remove Member: <input type='text' name='remove'>" . 
            "Add Council Member: <input type='text' name='council'>" . 
            "Edit Picture: <input type='file' name='fileToUpload' id='fileToUpload'>" . 
            "<input type='submit' name='submit'>";
            echo "</div>";
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(isset($actions) && !empty($actions)){
                    foreach($actions as $a){
                            echo "<p class='actions'>" . $a . "</p>";
                    }	
                }
            }
            include 'errors.php';
        }
        ?>

        <?php include '../include/footer.php';?>
        </body>
</html>
