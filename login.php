<?php
//includo i file necessari a collegarmi al db con relativo script di accesso

include_once("config.php");
ini_set("session.gc_maxlifetime","86400");
ini_set("session.cookie_lifetime","86400");
session_start();

//variabili POST con anti sql Injection
$username = mysqli_real_escape_string($con, $_POST['username']); //faccio l'escape dei caratteri dannosi
$password = mysqli_real_escape_string($con, sha1($_POST['password'])); //sha1 cifra la password anche qui in questo modo corrisponde con quella del db

$query = "SELECT * FROM utenti WHERE nome = '$username' AND password = '$password' ";
$ris = mysqli_query($con, $query) or die (mysqli_error($con));
$riga = mysqli_fetch_array($ris); 
 
/*Prelevo l'identificativo dell'utente */
$cod = $riga['nome'];
$id = $riga['id'];
 
/* Effettuo il controllo */
if ($cod == NULL) $trovato = 0 ;
else $trovato = 1; 
 
/* Username e password corrette */
if($trovato === 1) {
	 /*Registro la sessione*/
	 
	  $_SESSION["autorizzato"] = 1;
	 
	  /*Registro il codice dell'utente*/
	  $_SESSION['cod'] = $cod;
	  $_SESSION['idU'] = $id; // registro anche l'id che servira' per fare controlli incrociati nella verifica post-login.
	  	  
	 /*Redirect alla pagina riservata*/
	   echo '<script language=javascript>document.location.href="index.php"</script>';
	 
} else {
		/*Username e password errati, redirect alla pagina di login*/
	echo '<script language=javascript>document.location.href="login_form.php"</script>';
 
}
?>