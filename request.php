<?php ini_set('display_errors','Off');
error_reporting(E_ALL);
?>

<?php
include_once ('function.php');

//file esclusivamente per le richieste dai form

if ($_GET['action']=="new_atleta"){
	insert_atleta($con);
	$atleta = last_persona($con);
	$last_persona = $atleta['id'];
	header("Location: index.php?sez=atleti&mod=edit_atleta&id=$last_persona");
	
} elseif ($_GET['action']=="edit_atleta"){
	edit_atleta($con, $_GET['id']);
	upload($_GET['id']);
	header('Location: index.php?sez=atleti');
	
} elseif ($_GET['action']=="elimina_atleta"){
	elimina_persona($con,$_GET['id']);
	header('Location: index.php?sez=atleti');
	
} elseif ($_GET['action']=="cerca_atleta"){
	$id_atleta = $_POST['id_atleta'];
	$link = "index.php?sez=atleti&mod=edit_atleta&id=$id_atleta";
	header("Location: $link");
	
} elseif ($_GET['action']=="new_pag"){
	new_pag($con);
	$id_atleta = $_POST['id_persone'];
	header("Location: index.php?sez=atleti&mod=pagamenti&id=$id_atleta");
	
} elseif ($_GET['action']=="new_pag_rapido"){
	$id_persone = $_GET['id_persone'];
	$importo = $_GET['importo'];
	$data = date("Y-m-d");
	$causale = "men";
	if ($_GET['causale'] != ""){
		$causale = $_GET['causale'];
	}
	$descrizione = "Pagamento per mensilit&agrave; inserimento rapido";
	$mese = $_GET['mese'];
	new_pag_rapido($con, $id_persone, $importo, $data, $causale, $descrizione, $mese);
	header("Location: index.php?sez=atleti&mod=report_pagamenti");

} elseif ($_GET['action']=="remove_pag"){
	remove_pag($con, $_GET['id']);
	$id_atleta = $_GET['id_persone'];
	header("Location: index.php?sez=atleti&mod=pagamenti&id=$id_atleta");
	
} elseif ($_GET['action']=="remove_pag_rapido"){
	remove_pag_rapido($con, $_GET['id_persone'], $_GET['mese']);
	header("Location: index.php?sez=atleti&mod=report_pagamenti");
	
} elseif ($_GET['action']=="new_visita"){
	new_visita($con);
	$id_atleta = $_POST['id_persone'];
	header("Location: index.php?sez=atleti&mod=edit_atleta&id=$id_atleta");
	
} elseif ($_GET['action']=="mese_scaduto"){
	$id = $_POST['mese_scaduto'];
	header("Location: index.php?sez=atleti&mod=pagamenti&id=$id");
	
} elseif ($_GET['action']=="new_qualificazione"){
	new_qualificazione($con);
	$id_atleta = $_POST['id_persone'];
	header("Location: index.php?sez=atleti&mod=edit_atleta&id=$id_atleta");
	
}
?>