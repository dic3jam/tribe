<?php
declare(strict_types=1);
include '../class/class-register.php';
$_POST['username'] = "admin";
$_POST['password'] = "password";
$_POST['firstName'] = "admin";
$_POST['lastName'] = "admin";
$_POST['about'] = "the admin";
$reg = new register();
echo $reg->toString();
?>