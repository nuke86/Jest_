<?php 
include_once 'config.php';
session_start();
//se non c'e la sessione registrata
if (!$_SESSION['autorizzato']) {
  header("Location: login_form.php");
  die;
}
include 'header.php'; 
include 'main.php';
include 'footer.php';
?>
