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
    header("Location: profile.php");
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
        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] != 4) {
            fileUpload::delProPic($tribe->tribe_pic_loc);
            $tribe->setTribePic(fileUpload::storeProPic());
            $actions[] = "Tribe pic uploaded successfully";
            $_FILES['fileToUpload'] = '';
        }
    } catch (Exception $e) {
        $error[] = $e->getMessage();
    }
}
function echoCouncilTable($isCouncil, $tribe) {
    if($isCouncil)
        $id = "council";
    else
        $id = "noCouncil";

    echo "<div class='messageboard'" . $id . ">" . "<h3>" . $tribe->tribeName ." Board" . "</h3>";
    include '../include/messageBoard.php';

    echo "<div id='mb'></div> </div><!--messageboard-->";

    if($tribe->isCouncilMember) {
        echo "<div class='councilForm'>";
        echo "<h3 class='listTitle'>" . "Council Member Table" . "</h3>";
        echo "<form method='post' action='' enctype='multipart/form-data'>" .
        "Invite Members: <input type='text' name='invite'>" . 
        "Remove Member: <input type='text' name='remove'>" . 
        "Add Council Member: <input type='text' name='council'>" . 
        "Edit Picture: <input type='file' name='fileToUpload' id='fileToUpload'>" . 
        "<input type='submit' name='submit'>" .
        "</form>";
        echo "</div>"; //councilForm
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($actions) && !empty($actions)){
                foreach($actions as $a){
                        echo "<p class='actions'>" . $a . "</p>";
                }	
            }
        }
        include 'errors.php';
    }
   
}
?>
<!---------HEADER---------------------->
<?php include '../include/header.php';?>
<!------------------------------------->
    <script>var exports = {};</script>
    <script src='../js/messageboard.js'></script>
    <script>
        var xhr = new XMLHttpRequest();
        var url = "../src/get_messages.php?messageBoardID=<?php echo $tribe->messageBoardID?>";
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
    <nav id='tribe'>
        <h1>TRIBE</h1>
        <h2 class='title'><?php echo $tribe->tribeName?></h2>
        <a class="navLink" href="profile.php"><?php echo $tribe->username?></a>
        <?php include 'logout.php';?>
    </nav>
    </div> <!--header-->

    <div class='lsidebar'>
    <?php echo "<div class='list'>" . "<h3 class='listTitle'>" . "Tribal Members" . "</h3>";
            echo "<h4>Viewing Others Profiles Coming Soon!</h4>";
            echo "<ul>";
            for($i = 0; $i < count($tribe->tribeMembers) ; $i++){
                $username = $tribe->tribeMembers[$i][0];    
                $userID = $tribe->tribeMembers[$i][1];    
                echo "<li><a href='profile.php?userID=" . $userID . "'>"  . $username . "</a></li>";       
            }
        echo "</ul></div>";
    ?>
    </div><!--lsidebar-->

    <div class='main'>
        <div class='leftMain'>
            <div class="imgBox">
                <?php echo "<img src=$tribe->tribe_pic_loc alt='Unable to load image'>";?>
            </div><!--imgBox-->
            </div><!--leftMain-->

        <div class='rightMain'>
        <?php 
        if($tribe->isCouncilMember) {
            echoCouncilTable(true, $tribe);
        }else {
            echoCouncilTable(false, $tribe);
        }
        ?>
        </div><!--rightMain-->
    </div><!--main-->

    <div class="footer">
<!---------Footer---------------------->
<?php include '../include/footer.php';?>
<!------------------------------------->
        
