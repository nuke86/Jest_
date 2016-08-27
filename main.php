<?php
include_once('function.php');
?>

<?php if (($_GET['sez']=="start") OR ($_GET['sez']=="")) { ?>
<div class="panel panel-primary">
	<!-- Default panel contents -->
	<div class="panel-heading" style="text-align: center;"><b>Inizio attivit&agrave; [DESKTOP]</b></div>
	<div class="panel-body">
		<!-- Strumenti principali -->
		<table width="100%"><tr>
			<td><a class="btn btn-default" href="index.php?sez=atleti&mod=new_atleta"><i class="glyphicon glyphicon-plus"></i> Nuovo atleta</a>
			<a class="btn btn-default" href="index.php?sez=atleti"><i class="glyphicon glyphicon-list"></i> Elenco atleti</a>
			<a class="btn btn-default" href="index.php?sez=atleti&mod=report_pagamenti" title="Agenda annuale per i pagamenti di tutti gli atleti"><i class="glyphicon glyphicon-calendar"></i> Report pagamenti</a>
			</td><td width="30%">
				<div class="alert alert-info"><b align="center">Cerca atleta</b>
					<form action="request.php?action=cerca_atleta" method="POST"><input type="text" id="id_cliente" class="form-control" placeholder="Ricerca atleta per Nome o Cognome" />
					<input type="hidden" name="id_atleta" id="idclientejson" value="" />
					<input type="submit" class="form-control" value="Trova Profilo" />
					</form>
				</div>
			</td>
		</tr>
		<tr><td><b>AVVISI RAPIDI</b><br />
		Atleti che non hanno pagato la mensilit&agrave;: 
		<form action="request.php?action=mese_scaduto" method="POST">
			<select name="mese_scaduto"><?php echo atleti_mese_scaduto($con); ?></select>
			<input type="submit" value="Seleziona atleta" />
		</form>
		<br />
		Atleti con visita medica in scadenza: <br />
		</td></tr></table>
	</div>
</div>

<?php } elseif (($_GET['sez']=="atleti")AND($_GET['mod']=="")) { ?>
<div class="panel panel-primary">
	<!-- Default panel contents -->
	<div class="panel-heading" style="text-align: center;"><b>Gestione Atleti</b></div>
	<div class="panel-body">
		<!-- Strumenti principali -->
		<a class="btn btn-default" href="index.php?sez=atleti&mod=new_atleta"><i class="glyphicon glyphicon-plus"></i> Nuovo atleta</a>
		<a class="btn btn-default" href="index.php?sez=atleti&mod=report_pagamenti" title="Agenda annuale per i pagamenti di tutti gli atleti"><i class="glyphicon glyphicon-calendar"></i> Report pagamenti</a>
		<br /><br />
		<table class="table" style="text-align: center;">
		<tr><td><b>Codice</b></td>
		<td><b>Nome atleta</b></td>
		<td><b>Telefono</b></td>
		<td><b>Email</b></td>
		<td><b>Mese scorso</b></td>
		<td><b>Mese <?php echo date("m/Y"); ?></b></td>
		<td><b>Scadenza Visita Med.</b></td>
		<td><b>Opzioni</b></td></tr>
		<?php echo list_atleti($con); ?>

		</table>
	</div>
</div>	

<?php } elseif (($_GET['sez']=="atleti")AND($_GET['mod']=="new_atleta")) {?>
<div class="panel panel-primary">
	<!-- Default panel contents -->
	<div class="panel-heading" style="text-align: center;"><b>Inserimento atleta</b></div>
	<div class="panel-body">
		<!-- Strumenti principali -->
		<a class="btn btn-default" href="index.php?sez=atleti"><i class="glyphicon glyphicon-hand-left"></i> Elenco atleti</a><br /><br />
		(*): campi obbligatori.
		<table class="table" width="100%"><tr>
			<form action="request.php?action=new_atleta" method="POST">
			<td><input type="text" class="form-control" style="text-transform: uppercase;" name="nome" required placeholder="Nome *" /></td>
			<td width="50%"><input type="text" style="text-transform: uppercase;" class="form-control" name="cognome" required placeholder="Cognome *" /></td></tr><tr>
			<td>Data di Nascita:
  			  	<table><tr><td>
				<select name="giorno" class="form-control" style="width: 65px;">
					<?php
					for($i=1;$i<32;$i++){
						echo "<option value=\"" . $i . "\">" . $i . "</option>\n";
					}
					?>
				</select> 
				</td><td>
				<select name="mese" class="form-control" style="width: 140px;">
				<?php
				$mesiArray = array("Gennaio","Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", 
				"Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");
					for($i=1;$i<13;$i++){
						echo "<option value=\"" . $i . "\">" . $i." ". $mesiArray[$i-1] . "</option>\n";
					}
				?>
					</select>
				</td><td> 
					<select name="anno" class="form-control" style="width: 80px;">
						<?php
						for($i=1920;$i<2016;$i++){
							echo "<option value=\"" . $i . "\">" . $i . "</option>\n";
						}
						?>
					</select>
				</td><td width="60%">
				<input type="text" class="form-control" style="text-transform: uppercase;" name="cod_fiscale" placeholder="Codice Fiscale" /></td></tr></table>
			</td>
			<td><input type="text" class="form-control" name="indirizzo" placeholder="Indirizzo residenza" /></td></tr>
			<tr>
			<td><input type="text" class="form-control" required id="comune" name="comune" placeholder="Comune *" /></td>
			<td><input type="text" class="form-control" name="cap" placeholder="CAP" /></td></tr>
			<tr>
			<td><input type="text" class="form-control" name="nome_genitore" placeholder="Nome genitore" /></td>
			<td><input type="text" class="form-control" name="cognome_genitore" placeholder="Cognome genitore" /></td></tr>
			<tr>
			<td><input type="text" class="form-control" required name="telefono1" placeholder="Telefono 1 *" /></td>
			<td><input type="text" class="form-control" name="telefono2" placeholder="Telefono 2" /></td></tr>
			<tr>
			<td><input type="text" class="form-control" name="mail" placeholder="E-mail" /></td>
			</tr>
			<tr><td><input type="submit" class="btn btn-default" value="Conferma inserimento" /></td></tr>
			</form>
		</tr></table>
	</div>
</div><br /><br />

<?php } elseif (($_GET['sez']=="atleti")AND($_GET['mod']=="edit_atleta")) {
	$atleta = select_detail($con,$_GET['id'],'persone');
	?>
<div class="panel panel-primary">
	<!-- Default panel contents -->
	<div class="panel-heading" style="text-align: center;"><b>Modifica dati atleta</b></div>
	<div class="panel-body">
		<!-- Strumenti principali -->
		<a class="btn btn-default" href="index.php?sez=atleti"><i class="glyphicon glyphicon-hand-left"></i> Elenco atleti</a>
		<a href="index.php?sez=atleti&mod=pagamenti&id=<?php echo $atleta['id']; ?>" class="btn btn-default" title="Stato pagamenti"><i class="glyphicon glyphicon-euro"></i> Pagamenti</a>
		<a href="index.php?sez=atleti&mod=new_pag&id=<?php echo $atleta['id']; ?>" class="btn btn-default" title="Registra nuovo pagamento"><i class="glyphicon glyphicon-plus"></i> Nuovo pagamento</a>
		<a href="index.php?sez=atleti&mod=new_visita&id=<?php echo $atleta['id']; ?>" class="btn btn-default" title="Nuova visita medica"><i class="glyphicon glyphicon-plus"></i> Nuova visita medica</a>
		<a class="btn btn-default" href="index.php?sez=atleti&mod=report_pagamenti" title="Agenda annuale per i pagamenti di tutti gli atleti"><i class="glyphicon glyphicon-calendar"></i> Report pagamenti</a>
		<br /><br />
		(*): campi obbligatori.
		<table class="table" width="100%"><tr>
			<form action="request.php?action=edit_atleta&id=<?php echo $atleta['id']; ?>" method="POST" enctype="multipart/form-data">
			<td>Nome:<br />
			<input type="text" class="form-control" name="nome" required value="<?php echo $atleta['nome']; ?>" /></td>
			<td width="50%">Cognome:<br />
			<input type="text" class="form-control" name="cognome" required value="<?php echo $atleta['cognome']; ?>" /></td></tr><tr>
			<td>Data di Nascita:<br />
			<input type="text" style="width: 20%;" name="data_nascita" required value="<?php echo $atleta['data_nascita']; ?>" />
			Codice Fiscale: 
			<input type="text" style="width: 20%; text-transform: uppercase;" name="cod_fiscale" value="<?php echo $atleta['cod_fiscale']; ?>" />
			</td>
			<td>Indirizzo:<br />
			<input type="text" class="form-control" name="indirizzo" value="<?php echo $atleta['indirizzo']; ?>" /></td></tr>
			<tr>
			<td>Comune:<br />
			<input type="text" class="form-control" required id="comune" name="comune" value="<?php echo $atleta['comune']; ?>" /></td>
			<td>CAP:<br />
			<input type="text" class="form-control" name="cap" value="<?php echo $atleta['cap']; ?>" /></td></tr>
			<tr>
			<td>Nome genitore:<br />
			<input type="text" class="form-control" name="nome_genitore" value="<?php echo $atleta['nome_genitore']; ?>" /></td>
			<td>Cognome genitore:<br />
			<input type="text" class="form-control" name="cognome_genitore" value="<?php echo $atleta['cognome_genitore']; ?>" /></td></tr>
			<tr>
			<td>Telefono 1:<br />
			<input type="text" class="form-control" required name="telefono1" value="<?php echo $atleta['telefono1']; ?>" /></td>
			<td>Telefono 2:<br />
			<input type="text" class="form-control" name="telefono2" value="<?php echo $atleta['telefono2']; ?>" /></td></tr>
			<tr>
			<td>Email:<br />
			<input type="text" class="form-control" name="mail" value="<?php echo $atleta['mail']; ?>" /></td>
			<td><b>Documenti da archiviare</b> (facoltativo, puoi archiviare anche in un secondo momento):<br />
			<input type="file" id="file" name="docs[]" multiple="multiple" /><br /><br />
			</td></tr>
			<tr><td><b>VISITE MEDICHE:</b><br />
			<table><tr><td>Data scadenza || </td><td>Tipo</td></tr>
			<?php echo select_visite_persona($con, $atleta['id']); ?></table>
			</td><td><b>Archivio esistente</b>
			<div id="container"> </div><div id="selected_file"></div></td></tr>
			<tr><td>
			<input type="submit" class="btn btn-default" value="Salva modifiche" /></td></tr>
			</form>
		</tr></table>
	</div>
</div><br /><br />

<?php } elseif (($_GET['sez']=="atleti")AND($_GET['mod']=="pagamenti")) { 
	$atleta = select_detail($con,$_GET['id'],'persone');
	?>
	<div class="panel panel-primary">
	<!-- Default panel contents -->
	<div class="panel-heading" style="text-align: center;"><b>Stato dei pagamenti</b></div>
	<div class="panel-body">
	<a class="btn btn-default" href="index.php?sez=atleti"><i class="glyphicon glyphicon-hand-left"></i> Elenco atleti</a>
	<a class="btn btn-default" href="index.php?sez=atleti&mod=new_pag&id=<?php echo $atleta['id']; ?>"><i class="glyphicon glyphicon-plus"></i> Registra nuovo pagamento</a>
	<a class="btn btn-default" href="index.php?sez=atleti&mod=report_pagamenti" title="Agenda annuale per i pagamenti di tutti gli atleti"><i class="glyphicon glyphicon-calendar"></i> Report pagamenti</a>
	<br /><br />
	
	Lista di tutti i pagamenti di <b style="text-transform: uppercase;"><?php echo $atleta['cognome']. ' '.$atleta['nome']; ?></b>
	<table class="table" style="text-align: center;">
		<tr><td><b>Codice</b></td>
		<td><b>Data pagamento</b></td>
		<td><b>Riferito a</b></td>
		<td><b>Importo</b></td>
		<td><b>Causale</b></td>
		<td><b>Descrizione</b></td>
		</tr>
		<?php echo list_pagamenti($con, $atleta['id']); ?>

		</table>
	</div>
</div><br /><br />

<?php } elseif (($_GET['sez']=="atleti")AND($_GET['mod']=="new_pag")) { 
	$atleta = select_detail($con,$_GET['id'],'persone');
	?>
	<div class="panel panel-primary">
	<!-- Default panel contents -->
	<div class="panel-heading" style="text-align: center;"><b>Registrazione nuovo pagamento</b></div>
	<div class="panel-body">
	<a class="btn btn-default" href="index.php?sez=atleti&mod=pagamenti&id=<?php echo $_GET['id']; ?>"><i class="glyphicon glyphicon-hand-left"></i> Stato pagamenti</a>
	<a class="btn btn-default" href="index.php?sez=atleti"><i class="glyphicon glyphicon-list"></i> Elenco atleti</a>
	<br /><br />
	
	Stai registrando un nuovo pagamento per <b style="text-transform: uppercase;"><?php echo $atleta['cognome']. ' '.$atleta['nome']; ?></b>
	<br />
	<table class="table" width="100%"><tr>
			<form action="request.php?action=new_pag" method="POST">
			<input type="hidden" name="id_persone" value="<?php echo $_GET['id']; ?>" />
			<td>Importo in EURO: <input type="text" class="form-control" name="importo" required placeholder="Importo &euro;:" /></td>
			<td>Data del pagamento: <input type="text" class="form-control" name="data" value="<?php echo date("Y-m-d"); ?>" id="datepicker" /></td>
			<td>Mese di riferimento: <input type="text" class="form-control" name="mese" value="<?php echo date("m"); ?>" required id="datepicker1" /></td>
			<td>Causale: <select class="form-control" name="causale">
				<option value="iam">Iscrizione annuale + mensilit&agrave;</option>
				<option value="men" selected>Mensilit&agrave;</option>
				<option value="pac">Passaggio di cintura (esami)</option>
				<option value="vim">Spese per visita medica</option>
				</select>
			</td>
			<td>Descrizione: <input type="text" class="form-control" name="descrizione" placeholder="Note aggiuntive:" /></td>
			</tr><tr><td><input type="submit" class="btn btn-default" value="Conferma inserimento" /></td></tr>
			</form>
	</table>
	
	</div>
</div><br /><br />

<?php } elseif (($_GET['sez']=="atleti")AND($_GET['mod']=="report_pagamenti")) { ?>
<div class="panel panel-primary">
	<!-- Default panel contents -->
	<div class="panel-heading" style="text-align: center;"><b>Report completo pagamenti</b></div>
	<div class="panel-body">
		<!-- Strumenti principali -->
		<a class="btn btn-default" href="index.php?sez=atleti"><i class="glyphicon glyphicon-list"></i> Elenco atleti</a>
		<br /><br /><h3 align="center">ANNO <b><?php echo date("Y"); ?></b></h3><br />
		Cliccando sulla X rossa puoi rapidamente inserire il pagamento desiderato, al contrario se clicchi sul VISTO verde rimuoverai il pagamento per tale atleta. <br />
		<table class="table" style="text-align: center;">
		<tr><td>Nome atleta</td>
		<td><b>Gennaio</b></td>
		<td><b>Febbraio</b></td>
		<td><b>Marzo</b></td>
		<td><b>Aprile</b></td>
		<td><b>Maggio</b></td>
		<td><b>Giugno</b></td>
		<td><b>Luglio</b></td>
		<td><b>Agosto</b></td>
		<td><b>Settembre</b></td>
		<td><b>Ottobre</b></td>
		<td><b>Novembre</b></td>
		<td><b>Dicembre</b></td></tr>
		
		<?php echo report_pagamenti($con); ?>

		</table>
	</div>
</div><br /><br />

<?php } elseif (($_GET['sez']=="atleti")AND($_GET['mod']=="new_visita")) { 
	$atleta = select_detail($con,$_GET['id'],'persone');
	?>
	<div class="panel panel-primary">
	<!-- Default panel contents -->
	<div class="panel-heading" style="text-align: center;"><b>Inserimento nuova visita medica</b></div>
	<div class="panel-body">
	<a class="btn btn-default" href="index.php?sez=atleti&mod=edit_atleta&id=<?php echo $_GET['id']; ?>"><i class="glyphicon glyphicon-hand-left"></i> Torna a modifica atleta</a>
	<a class="btn btn-default" href="index.php?sez=atleti"><i class="glyphicon glyphicon-list"></i> Elenco atleti</a>
	<br /><br />
	
	Stai registrando una nuova visita medica per <b style="text-transform: uppercase;"><?php echo $atleta['cognome']. ' '.$atleta['nome']; ?></b>
	<br />
	<table class="table" width="100%"><tr>
			<form action="request.php?action=new_visita" method="POST">
			<input type="hidden" name="id_persone" value="<?php echo $_GET['id']; ?>" />
			<td>Data della visita: <input type="text" class="form-control" name="data" value="<?php echo date("Y-m-d"); ?>" id="datepicker" /></td>
			<td>Causale: <select class="form-control" name="causale">
				<option value="ago" selected>Agonistica</option>
				<option value="med">Normale</option>
				</select>
			</td>
			<td>Descrizione: <input type="text" class="form-control" name="descrizione" placeholder="Note aggiuntive:" /></td>
			</tr><tr><td><input type="submit" class="btn btn-default" value="Conferma inserimento" /></td></tr>
			</form>
	</table>
	
	</div>
</div><br /><br />

<?php } ?>
