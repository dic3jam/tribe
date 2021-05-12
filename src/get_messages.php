<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
/* messages.php
 * Retrieves the messages for either 
 * the user or the tribe whose 
 * messageboard is being instantiated
 */ 
include '../class/class-dbc.php';
include '../trait/trait-messageBoard.php';
include '../trait/trait-username.php';

$dbc = new dbc();
$posts = messageBoard::getAllPosts($dbc, ((int)$_POST['messageBoardID']));
$posts_new = array();
for($i = 0; $i < count($posts); $i++){
  $posts_new[$i] = array (
    "postID" => $posts[$i][0],
    "date" => $posts[$i][1],
    "username" => username::getUsername($posts[$i][2], $dbc),
    "message" => $posts[$i][3]
  );
}
$json = json_encode($posts_new);
echo $json;
