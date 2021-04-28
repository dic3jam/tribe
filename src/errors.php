<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($error) && !empty($error)){
		echo "<p class='errorheader'>Errors Occurred: </p>";
			foreach($error as $e){
				echo "<p class='error'>" . $e . "</p>";
			}	
		}
	}
?>