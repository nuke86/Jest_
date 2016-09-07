<?php
include_once ('config.php');


function upload ($id_atleta){
	//funzione per archiviare i documenti caricati
	$total = count($_FILES['docs']['name']);

	// Loop through each file
	for($i=0; $i<$total; $i++) {
	  //Get the temp file path
	  $tmpFilePath = $_FILES['docs']['tmp_name'][$i];
	  //Make sure we have a filepath
	  if ($tmpFilePath != ""){
		//Setup our new file path
		if (!file_exists("atleti/$id_atleta")) {
		mkdir("atleti/$id_atleta", 0777, true);
		}
		$newFilePath = "atleti/$id_atleta/" . $_FILES['docs']['name'][$i];
		//Upload the file into the temp dir
		if(move_uploaded_file($tmpFilePath, $newFilePath)) {
		  //Handle other code here
	
		}
	  }
	}
}

function insert_atleta($con){
	// escape variables for security
	$nome = mysqli_real_escape_string($con, $_POST['nome']);
	$cognome = mysqli_real_escape_string($con, $_POST['cognome']);
	$cod_fiscale = mysqli_real_escape_string($con, $_POST['cod_fiscale']);
	$indirizzo = mysqli_real_escape_string($con, $_POST['indirizzo']);
	$data_nascita = $_POST['anno'].'-'.$_POST['mese'].'-'.$_POST['giorno'];
	$comune = mysqli_real_escape_string($con, $_POST['comune']);
	$cap = mysqli_real_escape_string($con, $_POST['cap']);
	$telefono1 = mysqli_real_escape_string($con, $_POST['telefono1']);
	$telefono2 = mysqli_real_escape_string($con, $_POST['telefono2']);
	$mail = mysqli_real_escape_string($con, $_POST['mail']);
	$nome_genitore = mysqli_real_escape_string($con, $_POST['nome_genitore']);
	$cognome_genitore = mysqli_real_escape_string($con, $_POST['cognome_genitore']);

	
	$sql="INSERT INTO persone (id, nome, cognome, cod_fiscale, indirizzo, data_nascita, comune, cap, telefono1, telefono2, mail, nome_genitore, 
		cognome_genitore)
		VALUES (NULL, '$nome', '$cognome', '$cod_fiscale', '$indirizzo', '$data_nascita', '$comune', '$cap', '$telefono1','$telefono2', '$mail', 
		'$nome_genitore', '$cognome_genitore')";
	
	if (!mysqli_query($con,$sql)) {
  		die('Error: ' . mysqli_error($con));
	}
	//echo "1 record added";

}

function select_detail($con,$id,$table){
	// imposto ed eseguo la query
	$query = "SELECT * FROM $table WHERE id=$id";
	$result = mysqli_query($con, $query) or die('Errore...funzione select_details '.$table.' '.$id);
	$riga = mysqli_fetch_array($result);
	
	return $riga;
}

function edit_atleta($con,$id){
	$nome = mysqli_real_escape_string($con, $_POST['nome']);
	$cognome = mysqli_real_escape_string($con, $_POST['cognome']);
	$cod_fiscale = mysqli_real_escape_string($con, $_POST['cod_fiscale']);
	$indirizzo = mysqli_real_escape_string($con, $_POST['indirizzo']);
	$data_nascita = mysqli_real_escape_string($con, $_POST['data_nascita']);
	$comune = mysqli_real_escape_string($con, $_POST['comune']);
	$cap = mysqli_real_escape_string($con, $_POST['cap']);
	$telefono1 = mysqli_real_escape_string($con, $_POST['telefono1']);
	$telefono2 = mysqli_real_escape_string($con, $_POST['telefono2']);
	$mail = mysqli_real_escape_string($con, $_POST['mail']);
	$nome_genitore = mysqli_real_escape_string($con, $_POST['nome_genitore']);
	$cognome_genitore = mysqli_real_escape_string($con, $_POST['cognome_genitore']);
	
	$sql = "UPDATE persone SET nome='$nome', cognome='$cognome', cod_fiscale='$cod_fiscale', 
			indirizzo='$indirizzo', data_nascita='$data_nascita', 
			comune='$comune', cap='$cap', telefono1='$telefono1', telefono2='$telefono2', 
			mail='$mail', nome_genitore='$nome_genitore', 
			cognome_genitore='$cognome_genitore'
			WHERE id=$id";
			
	// controllo l'esito
	if (!mysqli_query($con,$sql)) {
  		die('Error: ' . mysqli_error($con));
	}

	mysqli_close($con);
}

function list_atleti($con){
	// imposto ed eseguo la query
	$query = "SELECT * FROM persone ORDER BY cognome ASC";
	$result = mysqli_query($con, $query) or die('Errore... lista');
	
	// conto il numero di occorrenze trovate nel db
	$numrows = mysqli_num_rows($result);
	
	// se il database è vuoto lo stampo a video
	if ($numrows == 0){
	  $select_finale = "Database vuoto!";
	} else {
	  // avvio un ciclo for che si ripete per il numero di occorrenze trovate
	  while ($results = mysqli_fetch_array($result)) {   
		
		// recupero il contenuto di ogni record rovato
		$id = $results['id'];
		$nome = $results['nome'];
		$cognome = $results['cognome'];
		$telefono1 = $results['telefono1'];
		$mail = $results['mail'];
	
		// stampo a video il risultato
		$mese_now = date("m");
		$segno = pagamento_mese($con, $mese_now, $id, "men");
		$mese_scorso = date("m", strtotime('-1 month'));
		$segno_scorso = pagamento_mese($con, $mese_scorso, $id, "men");
		$visita = last_visita($con, $id);
	   
			$select_finale .= "
			<tr><td>".$id."</td><td style=\"text-transform: uppercase;\"><a href=\"index.php?sez=atleti&mod=edit_atleta&id=$id\">".$cognome." ".$nome."</a></td><td>".$telefono1.
			"</td><td>".$mail."</td><td>".$segno_scorso."</td><td>".$segno."</td><td>$visita</td>
			<td>
			<a href=\"index.php?sez=atleti&mod=edit_atleta&id=$id\" class=\"btn btn-sm btn-primary\" title=\"Modifica anagrafica e documenti\"><i class=\"glyphicon glyphicon-pencil\"></i></a>
			<a href=\"index.php?sez=atleti&mod=pagamenti&id=$id\" class=\"btn btn-sm btn-primary\" title=\"Stato pagamenti\"><i class=\"glyphicon glyphicon-euro\"></i></a>
			<a href=\"index.php?sez=atleti&mod=new_pag&id=$id\" class=\"btn btn-sm btn-primary\" title=\"Registra nuovo pagamento\"><i class=\"glyphicon glyphicon-plus\"></i></a>
			<a href=\"request.php?action=elimina_atleta&id=$id\" onclick=\"return confirm('Sicuro di voler ELIMINARE $cognome $nome ? Operazione NON REVERSIBILE');\" class=\"btn btn-sm btn-primary\" title=\"Elimina questo atleta\"><i class=\"glyphicon glyphicon-remove\"></i></a>
			</td></tr>
			";
		
	  }
	}
	
	// chiudo la connessione
	mysqli_close($con);
	
	return $select_finale;
}

function last_persona($con){
	$query = "SELECT * FROM persone ORDER BY id DESC LIMIT 1";
	$result = mysqli_query($con, $query) or die('Errore... ultimo atleta');
	$riga = mysqli_fetch_array($result);
	return $riga;
}

function elimina_persona($con,$id){
	$query = "DELETE FROM persone WHERE id = $id";
	$result = mysqli_query($con, $query) or die('Errore...');
	return $result;
}

function new_pag($con){
	// escape variables for security
	$id_persone = mysqli_real_escape_string($con, $_POST['id_persone']);
	$importo = mysqli_real_escape_string($con, $_POST['importo']);
	$importo = money_format('%.1n0',$importo);
	$data = mysqli_real_escape_string($con, $_POST['data']);
	$causale = mysqli_real_escape_string($con, $_POST['causale']);
	$descrizione = mysqli_real_escape_string($con, $_POST['descrizione']);
	$mese = mysqli_real_escape_string($con, $_POST['mese']);

	
	$sql="INSERT INTO abbonamenti (id, id_persone, prezzo, descrizione, causale, data, mese)
		VALUES (NULL, '$id_persone', '$importo', '$descrizione', '$causale', '$data', '$mese')";
	
	if (!mysqli_query($con,$sql)) {
  		die('Error: ' . mysqli_error($con));
	}
	//echo "1 record added";

	mysqli_close($con);
}

function new_visita($con){
	// escape variables for security
	$id_persone = mysqli_real_escape_string($con, $_POST['id_persone']);
	$data = mysqli_real_escape_string($con, $_POST['data']);
	$causale = mysqli_real_escape_string($con, $_POST['causale']);
	$descrizione = mysqli_real_escape_string($con, $_POST['descrizione']);
	
	$sql="INSERT INTO visite (id, id_persone, data, descrizione, causale)
		VALUES (NULL, '$id_persone', '$data', '$descrizione', '$causale')";
	
	if (!mysqli_query($con,$sql)) {
  		die('Error: ' . mysqli_error($con));
	}
	//echo "1 record added";

	mysqli_close($con);
}

function new_qualificazione($con){
	// escape variables for security
	$id_persone = mysqli_real_escape_string($con, $_POST['id_persone']);
	$data = mysqli_real_escape_string($con, $_POST['data']);
	$risultato = mysqli_real_escape_string($con, $_POST['risultato']);
	$gara = mysqli_real_escape_string($con, $_POST['gara']);
	
	$sql="INSERT INTO gare (id, id_atleta, data, id_gara, risultato)
		VALUES (NULL, '$id_persone', '$data', '$gara', '$risultato')";
	
	if (!mysqli_query($con,$sql)) {
  		die('Error: ' . mysqli_error($con));
	}
	//echo "1 record added";

	mysqli_close($con);
}

function new_pag_rapido($con, $id_persone, $importo, $data, $causale, $descrizione, $mese){
	// escape variables for security
	$id_persone = mysqli_real_escape_string($con, $id_persone);
	$importo = mysqli_real_escape_string($con, $importo);
	$importo = money_format('%.1n0',$importo);
	$data = mysqli_real_escape_string($con, $data);
	$causale = mysqli_real_escape_string($con, $causale);
	$descrizione = mysqli_real_escape_string($con, $descrizione);
	$mese = mysqli_real_escape_string($con, $mese);

	
	$sql="INSERT INTO abbonamenti (id, id_persone, prezzo, descrizione, causale, data, mese)
		VALUES (NULL, '$id_persone', '$importo', '$descrizione', '$causale', '$data', '$mese')";
	
	if (!mysqli_query($con,$sql)) {
  		die('Error: ' . mysqli_error($con));
	}
	//echo "1 record added";

	mysqli_close($con);
}

function pagamento_mese($con, $mese, $id_persone, $causale){
	$anno = date("Y");
	$query = "SELECT * FROM abbonamenti WHERE id_persone = $id_persone AND causale = '$causale' AND causale = 'iam' AND mese = '$mese' AND data LIKE '$anno%'";
	$result = mysqli_query($con, $query) or die('Errore... pagamenti');
	
	// conto il numero di occorrenze trovate nel db
	$numrows = mysqli_num_rows($result);
	
	// se il database è vuoto lo stampo a video
	if ($numrows != 0){
		$segno = "<i style=\"color: green;\" class=\"glyphicon glyphicon-ok\"></i>";
	  } else {
	  	$segno = "Paga";
	  }
	return $segno;
}

function pagamento_mese_rapido($con, $mese, $id_persone, $causale){
	$anno = date("Y");
	$query = "SELECT * FROM abbonamenti WHERE id_persone = $id_persone AND causale = '$causale' AND mese = '$mese' AND causale = 'iam' AND data LIKE '$anno%'";
	$result = mysqli_query($con, $query) or die('Errore... pagamenti');
	
	// conto il numero di occorrenze trovate nel db
	$numrows = mysqli_num_rows($result);
	
	// se il database è vuoto lo stampo a video
	if ($numrows == 0){
		$segno = 0;
	} else {
		$segno = 1;
	  }
	return $segno;
}

function list_pagamenti($con, $id_persone){
	// imposto ed eseguo la query
	$query = "SELECT * FROM abbonamenti WHERE id_persone = $id_persone ORDER BY id DESC";
	$result = mysqli_query($con, $query) or die('Errore... lista pagamenti');
	
	// conto il numero di occorrenze trovate nel db
	$numrows = mysqli_num_rows($result);
	
	// se il database è vuoto lo stampo a video
	if ($numrows == 0){
	  $select_finale = "<tr><td>Database vuoto!</td></tr>";
	} else {
	  // avvio un ciclo for che si ripete per il numero di occorrenze trovate
	  while ($results = mysqli_fetch_array($result)) {   
		
		// recupero il contenuto di ogni record rovato
		$id = $results['id'];
		$data = $results['data'];
		$causale = $results['causale'];
		$descrizione = $results['descrizione'];
		$mese = $results['mese'];
		$importo = $results['prezzo'];
		
		// Traduco mesi e causali in linquaggio umano
		if ($mese == "01") {
			$mese = "Gennaio";
		} elseif ($mese == "02") {
			$mese = "Febbraio";
		} elseif ($mese == "03") {
			$mese = "Marzo";
		} elseif ($mese == "04") {
			$mese = "Aprile";
		} elseif ($mese == "05") {
			$mese = "Maggio";
		} elseif ($mese == "06") {
			$mese = "Giugno";
		} elseif ($mese == "07") {
			$mese = "Luglio";
		} elseif ($mese == "08") {
			$mese = "Agosto";
		} elseif ($mese == "09") {
			$mese = "Settembre";
		} elseif ($mese == "10") {
			$mese = "Ottobre";
		} elseif ($mese == "11") {
			$mese = "Novembre";
		} elseif ($mese == "12") {
			$mese = "Dicembre";
		}
		
		if ($causale == "iam") {
			$causale = "Iscrizione annuale + mensilit&agrave;";
		} elseif ($causale == "men") {
			$causale = "Mensilit&agrave;";
		} elseif ($causale == "pac") {
			$causale = "Passaggio di cintura (esami)";
		} elseif ($causale == "vim") {
			$causale = "Spese per visita medica";
		}
	
		// stampo a video il risultato
	   
			$select_finale .= "
			<tr><td>".$id."</td><td>".$data."</td><td>".$mese."</td><td>".$importo."</td><td>".$causale."</td><td>".$descrizione."</td></tr>
			";
		
	  }
	}
	
	// chiudo la connessione
	mysqli_close($con);
	
	return $select_finale;
}

function report_pagamenti($con){
	// imposto ed eseguo la query
	$query = "SELECT * FROM persone ORDER BY cognome ASC";
	$result = mysqli_query($con, $query) or die('Errore... report pagamenti');
	
	// conto il numero di occorrenze trovate nel db
	$numrows = mysqli_num_rows($result);
	
	// se il database è vuoto lo stampo a video
	if ($numrows == 0){
	  $select_finale = "Database vuoto!";
	} else {
	  // avvio un ciclo for che si ripete per il numero di occorrenze trovate
	  while ($results = mysqli_fetch_array($result)) {   
		
		// recupero il contenuto di ogni record rovato
		$id = $results['id'];
		$nome = $results['nome'];
		$cognome = $results['cognome'];
	
		// stampo a video il risultato
		$gennaio = pagamento_mese($con, "01", $id, "men");
		$febbraio = pagamento_mese($con, "02", $id, "men");
		$marzo = pagamento_mese($con, "03", $id, "men");
		$aprile = pagamento_mese($con, "04", $id, "men");
		$maggio = pagamento_mese($con, "05", $id, "men");
		$giugno = pagamento_mese($con, "06", $id, "men");
		$luglio = pagamento_mese($con, "07", $id, "men");
		$agosto = pagamento_mese($con, "08", $id, "men");
		$settembre = pagamento_mese($con, "09", $id, "men");
		$ottobre = pagamento_mese($con, "10", $id, "men");
		$novembre = pagamento_mese($con, "11", $id, "men");
		$dicembre = pagamento_mese($con, "12", $id, "men");
		
		// genero i link per la tabella
		$gennaio_r = pagamento_mese_rapido($con, "01", $id, "men");
		$febbraio_r = pagamento_mese_rapido($con, "02", $id, "men");
		$marzo_r = pagamento_mese_rapido($con, "03", $id, "men");
		$aprile_r = pagamento_mese_rapido($con, "04", $id, "men");
		$maggio_r = pagamento_mese_rapido($con, "05", $id, "men");
		$giugno_r = pagamento_mese_rapido($con, "06", $id, "men");
		$luglio_r = pagamento_mese_rapido($con, "07", $id, "men");
		$agosto_r = pagamento_mese_rapido($con, "08", $id, "men");
		$settembre_r = pagamento_mese_rapido($con, "09", $id, "men");
		$ottobre_r = pagamento_mese_rapido($con, "10", $id, "men");
		$novembre_r = pagamento_mese_rapido($con, "11", $id, "men");
		$dicembre_r = pagamento_mese_rapido($con, "12", $id, "men");
		if ($gennaio_r == 0) {
			$link01 = "
			<div class=\"btn-group\">
			  <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
			    $gennaio <span class=\"caret\"></span>
			  </button>
			  <ul class=\"dropdown-menu\">
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=01&importo=25\">25 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=01&importo=35\">35 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=01&importo=65\">65 EURO</a></li>
			  </ul>
			</div>
			";
		} else {
			$link01 = "<a href=\"request.php?action=remove_pag_rapido&id_persone=$id&mese=01\">$gennaio</a>";
		}
		if ($febbraio_r == 0) {
			$link02 = "<div class=\"btn-group\">
			  <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
			    $febbraio <span class=\"caret\"></span>
			  </button>
			  <ul class=\"dropdown-menu\">
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=02&importo=25\">25 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=02&importo=35\">35 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=02&importo=65\">65 EURO</a></li>
			  </ul>
			</div>";
		} else {
			$link02 = "<a href=\"request.php?action=remove_pag_rapido&id_persone=$id&mese=02\">$febbraio</a>";
		}
		if ($marzo_r == 0) {
			$link03 = "<div class=\"btn-group\">
			  <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
			    $marzo <span class=\"caret\"></span>
			  </button>
			  <ul class=\"dropdown-menu\">
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=03&importo=25\">25 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=03&importo=35\">35 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=03&importo=65\">65 EURO</a></li>
			  </ul>
			</div>";
		} else {
			$link03 = "<a href=\"request.php?action=remove_pag_rapido&id_persone=$id&mese=03\">$marzo</a>";
		}
		if ($aprile_r == 0) {
			$link04 = "<div class=\"btn-group\">
			  <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
			    $aprile <span class=\"caret\"></span>
			  </button>
			  <ul class=\"dropdown-menu\">
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=04&importo=25\">25 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=04&importo=35\">35 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=04&importo=65\">65 EURO</a></li>
			  </ul>
			</div>";
		} else {
			$link04 = "<a href=\"request.php?action=remove_pag_rapido&id_persone=$id&mese=04\">$aprile</a>";
		}
		if ($maggio_r == 0) {
			$link05 = "<div class=\"btn-group\">
			  <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
			    $maggio <span class=\"caret\"></span>
			  </button>
			  <ul class=\"dropdown-menu\">
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=05&importo=25\">25 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=05&importo=35\">35 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=05&importo=65\">65 EURO</a></li>
			  </ul>
			</div>";
		} else {
			$link05 = "<a href=\"request.php?action=remove_pag_rapido&id_persone=$id&mese=05\">$maggio</a>";
		}
		if ($giugno_r == 0) {
			$link06 = "<div class=\"btn-group\">
			  <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
			    $giugno <span class=\"caret\"></span>
			  </button>
			  <ul class=\"dropdown-menu\">
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=06&importo=25\">25 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=06&importo=35\">35 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=06&importo=65\">65 EURO</a></li>
			  </ul>
			</div>";
		} else {
			$link06 = "<a href=\"request.php?action=remove_pag_rapido&id_persone=$id&mese=06\">$giugno</a>";
		}
		if ($luglio_r == 0) {
			$link07 = "<div class=\"btn-group\">
			  <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
			    $luglio <span class=\"caret\"></span>
			  </button>
			  <ul class=\"dropdown-menu\">
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=07&importo=25\">25 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=07&importo=35\">35 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=07&importo=65\">65 EURO</a></li>
			  </ul>
			</div>";
		} else {
			$link07 = "<a href=\"request.php?action=remove_pag_rapido&id_persone=$id&mese=07\">$luglio</a>";
		}
		if ($agosto_r == 0) {
			$link08 = "<div class=\"btn-group\">
			  <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
			    $agosto <span class=\"caret\"></span>
			  </button>
			  <ul class=\"dropdown-menu\">
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=08&importo=25\">25 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=08&importo=35\">35 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=08&importo=65\">65 EURO</a></li>
			  </ul>
			</div>";
		} else {
			$link08 = "<a href=\"request.php?action=remove_pag_rapido&id_persone=$id&mese=08\">$agosto</a>";
		}
		if ($settembre_r == 0) {
			$link09 = "<div class=\"btn-group\">
			  <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
			    $settembre <span class=\"caret\"></span>
			  </button>
			  <ul class=\"dropdown-menu\">
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=09&importo=25\">25 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=09&importo=35\">35 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=09&importo=65\">65 EURO</a></li>
			  </ul>
			</div>";
		} else {
			$link09 = "<a href=\"request.php?action=remove_pag_rapido&id_persone=$id&mese=09\">$settembre</a>";
		}
		if ($ottobre_r == 0) {
			$link10 = "<div class=\"btn-group\">
			  <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
			    $ottobre <span class=\"caret\"></span>
			  </button>
			  <ul class=\"dropdown-menu\">
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=10&importo=25\">25 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=10&importo=35\">35 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=10&importo=65\">65 EURO</a></li>
			  </ul>
			</div>";
		} else {
			$link10 = "<a href=\"request.php?action=remove_pag_rapido&id_persone=$id&mese=10\">$ottobre</a>";
		}
		if ($novembre_r == 0) {
			$link11 = "<div class=\"btn-group\">
			  <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
			    $novembre <span class=\"caret\"></span>
			  </button>
			  <ul class=\"dropdown-menu\">
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=11&importo=25\">25 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=11&importo=35\">35 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=11&importo=65\">65 EURO</a></li>
			  </ul>
			</div>";
		} else {
			$link11 = "<a href=\"request.php?action=remove_pag_rapido&id_persone=$id&mese=11\">$novembre</a>";
		}
		if ($dicembre_r == 0) {
			$link12 = "<div class=\"btn-group\">
			  <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
			    $dicembre <span class=\"caret\"></span>
			  </button>
			  <ul class=\"dropdown-menu\">
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=12&importo=25\">25 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=12&importo=35\">35 EURO</a></li>
			    <li><a href=\"request.php?action=new_pag_rapido&id_persone=$id&mese=12&importo=65\">65 EURO</a></li>
			  </ul>
			</div>";
		} else {
			$link12 = "<a href=\"request.php?action=remove_pag_rapido&id_persone=$id&mese=12\">$dicembre</a>";
		}

	   
			$select_finale .= "
			<tr><td style=\"text-transform: uppercase;\"><a href=\"index.php?sez=atleti&mod=edit_atleta&id=$id\">".$cognome." ".$nome."</a></td>
			<td>".$link01."</td>
			<td>".$link02."</a></td>
			<td>".$link03."</a></td>
			<td>".$link04."</a></td>
			<td>".$link05."</a></td>
			<td>".$link06."</a></td>
			<td>".$link07."</a></td>
			<td>".$link08."</a></td>
			<td>".$link09."</a></td>
			<td>".$link10."</a></td>
			<td>".$link11."</a></td>
			<td>".$link12."</a></td>
			</tr>
			";
		
	  }
	}
	
	// chiudo la connessione
	mysqli_close($con);
	
	return $select_finale;
}

function remove_pag_rapido($con,$id_persone,$mese){
	$anno = date("Y");
	
	$query = "DELETE FROM abbonamenti WHERE id_persone = $id_persone AND mese = $mese AND causale = 'men' AND data LIKE '$anno%'";
	$result = mysqli_query($con, $query) or die('Errore...');
	return $result;
}

function atleti_mese_scaduto($con){
	$anno = date("Y");
	$mese = date("m");
	$query = "SELECT * FROM persone ORDER BY cognome ASC";
	$result = mysqli_query($con, $query) or die('Errore... mese_scaduto');
	while ($results = mysqli_fetch_array($result)) { 
		$nome = $results['nome'];
		$cognome = $results['cognome'];
		$id = $results['id'];
		
		$query1 = "SELECT * FROM abbonamenti WHERE causale = 'men' AND mese = '$mese' AND data LIKE '$anno%' AND id_persone = $id";
		$result1 = mysqli_query($con, $query1) or die('Errore... pagamenti mese scaduto');
		$numrows = mysqli_num_rows($result1);
		if ($numrows == 0){
			$riga .= "<option value=\"$id\">$cognome $nome</option>";
		}
			
	}
	if ($riga == "") {
		$riga = "<option>Tutti i pagamenti sono OK</option> <i style=\"color: green;\" class=\"glyphicon glyphicon-ok\"></i>";
	}
	return $riga;
}

function delta_tempo ($data_iniziale,$data_finale,$unita) {
 
	 $data1 = strtotime($data_iniziale);
	 $data2 = strtotime($data_finale);
	 
		switch($unita) {
			case "m": $unita = 1/60; break; 	//MINUTI
			case "h": $unita = 1; break;		//ORE
			case "g": $unita = 24; break;		//GIORNI
			case "a": $unita = 8760; break;         //ANNI
		}
	 
	$differenza = (($data2-$data1)/3600)/$unita;
	return $differenza;
}

function atleti_visita_scaduta($con){
	$oggi = date("Y-m-d");
	$mese_prox = date("Y-m-d", strtotime("+1 month", strtotime($oggi)));
	$query = "SELECT * FROM persone ORDER BY cognome ASC";
	$result = mysqli_query($con, $query) or die('Errore... mese_scaduto');
	while ($results = mysqli_fetch_array($result)) { 
		$nome = $results['nome'];
		$cognome = $results['cognome'];
		$id = $results['id'];
		$differenza = 0;
		
		$query1 = "SELECT * FROM visite WHERE id_persone = $id ORDER BY data DESC LIMIT 1";
		$result1 = mysqli_query($con, $query1) or die('Errore... visite mese scaduto');
		while ($results1 = mysqli_fetch_array($result1)) { 
			$data = $results1['data'];
			$scadenza = date("Y-m-d", strtotime("+1 year", strtotime($data)));
		}	
		$differenza_oggi = delta_tempo($scadenza, $oggi, "g");
		$differenza_prox = delta_tempo($scadenza, $mese_prox, "g");
		//echo "$scadenza <br /> $oggi <br /> $differenza <br />";
		if (($differenza_oggi > 0) OR ($differenza_prox > 0)){
			$riga .= "<option value=\"$id\">$cognome $nome</option>";
		}
	}
	if ($riga == "") {
		$riga = "<option>Tutte le visite sono OK</option> <i style=\"color: green;\" class=\"glyphicon glyphicon-ok\"></i>";
	}
	return $riga;
}


function select_visite_persona($con, $id_persone){
	$query = "SELECT * FROM visite WHERE id_persone = $id_persone ORDER BY data DESC";
	$result = mysqli_query($con, $query) or die('Errore... visite');
	while ($results = mysqli_fetch_array($result)) { 
		$data = $results['data'];
		$causale = $results['causale'];
		
		$scadenza = date("d-m-Y", strtotime("+1 year", strtotime($data)));
		if ($causale == "ago"){
			$causale = "Agonistica";
		} else {
			$causale = "Normale";
		}
		$riga .= "<tr><td>$scadenza</td><td>$causale</td></tr>";
	}
	return $riga;
}

function last_visita($con, $id_persone){
	$query = "SELECT * FROM visite WHERE id_persone = $id_persone ORDER BY data DESC LIMIT 1";
	$result = mysqli_query($con, $query) or die('Errore... ultima visita');
	while ($results = mysqli_fetch_array($result)) { 
		$data = $results['data'];
		$scadenza = date("d-m-Y", strtotime("+1 year", strtotime($data)));
		
		$riga = "$scadenza";
	}
	return $riga;
}

function array_gare(){
	$lista_gare = array("Gran Prix Regionale",
				"Torneo FOX Quartu",
				"Coppa dell'amicizia",
				"Qualif. Camp. ITA",
				"Torneo Piccoli Samurai",
				"Campionato Italiano",
				"Trofeo Catalano",
				"Trofeo Judo Yano",
				"Torneo Jigoro Kano",
				"Trofeo Paperino",
				"Trofeo Salvo d'Aquisto",
				"Torneo J.C. Macomer",
				"Trofeo Sardigna Trophy",
				"Qualif. Camp. ITA Assoluti",
				"Trofeo La Maddalena",
				"Trofeo Garibaldino",
				"Torneo a squadre Shardana",
				"Camp. Progetto Farfalla",
				"Cagliari CUP",
				"Torneo Citt&agrave; di Quartu",
				"Qualif. Coppa Italia",
				"Torneo C.S. Olbia",
				"Torneo Memorial Giovannino Volpi",
				"Gran premio Cinture nere",
				"Torneo Guido Sieni Judo CUP",
				"Torneo J.K. Isili",
				"Trofeo Topolino",
				"Trofeo Judo in action",
				"Campionati Regionali Assoluti",
				"Baby Ippon");
	return $lista_gare;
}

function select_gare($id){
	$array_gare = array_gare();
	$dim = count($array_gare);
	
	for ($i=0; $i < $dim; $i++) {
		$riga .= "<option value=\"$i\">$array_gare[$i]</option>";
		
		if (($id != "all") AND ($id == $i)){
			$riga = "<option value=\"$i\" selected>$array_gare[$i]</option>";
		}
		
	}
	return $riga;
}

function risultato_gare($id){
	if ($id == 1){
		$risultato = "Primo";
	} else if ($id == 2){
		$risultato = "Secondo";
	} else if ($id == 3){
		$risultato = "Terzo";
	} else if ($id == 5){
		$risultato = "Quinto";
	}
	return $risultato;
}


function riga_gare_db($con, $id){
	$query = "SELECT * FROM gare WHERE id_atleta = $id ORDER BY data DESC";
	$result = mysqli_query($con, $query) or die('Errore... gare');
	while ($results = mysqli_fetch_array($result)) { 
		$data = $results['data'];
		$data = date("d/m/Y", strtotime($data));
		$risultato = $results['risultato'];
		$risultato = risultato_gare($risultato);
		$id_gara = $results['id_gara'];
		$gara = array_gare()[$id_gara];
		
		
		$riga .= "<tr><td>| $gara |</td><td>| $data |</td><td>| $risultato |</td></tr>";
	}
	return $riga;
}

?>
