<?php
include '../class/class-login.php';

$didthiswork = new login("jimbo", "dont.panic");

echo $didthiswork->toString();
?>