<?php
// configurazione del programma
//ini_set('session.gc_maxlifetime','14400');  // impostazione per la durata delle sessioni.

// Dati e Intestazioni aziendali
$nome_azienda = "FoxClub Judo";
$costo_mese_config = "35.00"; // il costo fisso del mensile per ogni atleta

// impostazioni del database Mysql
$mysql_ip = "localhost";
$db_name = "gest_foxclub";
$db_user = "root";
$db_pass = "70r853eka2";

// connessione utilizzata per tutte le funzioni di Database in tutto MercUsa
$con=mysqli_connect($mysql_ip,$db_user,$db_pass,$db_name);
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>