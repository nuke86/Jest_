<?php
include_once("config.php");

session_start();
$_SESSION = array();
session_destroy(); //distruggo tutte le sessioni
setcookie("PHPSESSID","",time()-3600,"/");
header("location: login_form.php");
exit();
?>