<?php
include '../class/class-dbc.php';
$dbc = new dbc();
try {
	//$result = $dbc->runQuery("addTribeMembership", 'iii', 1, 2, 0);
	//$result = $dbc->runQuery("getAllTribalMemberships", 'i', 1);
	$result = $dbc->runQuery("createNewUser", 'ssssss', "admin", "password", "admin", "admin", "uploads/temp_pic.png", "the admin");
	echo $result;
} catch (Exception $e) {
	echo $e->getMessage();
}

?>
