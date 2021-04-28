<?php

$errors = array();

if(isset($errors) && !empty($errors)){
	echo "<p class='error'>Errors Occurred: </p>";
	foreach($errors as $e){
		echo $e . "<br>";
	}
}

?>
