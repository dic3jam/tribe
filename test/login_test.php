<?php
include '../class/class-login.php';

$didthiswork = new login("", "dont.panic");

echo $didthiswork->toString();
?>