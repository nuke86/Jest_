<?php ini_set('display_errors','Off');
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Gestionale Web - <?php echo $nome_azienda; ?></title>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="explore/css/filetree.css" type="text/css" >



<!-- Optional theme -->

<style>
.btn-primary:visited { 
	background-color: red;
}
.btn-default {
	border: 1px solid;
}
.form-control {
	border: 1px solid;
}

</style>
<script>
$(document).ready(function($){
$("#id_cliente").autocomplete({
source:"cerca_atleta.php",
select: function( event, ui ) {
	var idCliente = ui.item.id_cliente;
	document.getElementById("idclientejson").value=idCliente;
      }
    });
});
</script>

<script>
$(document).ready(function($){
    $("#id_articolo").autocomplete({
	source:"cerca_articoli.php"
    });
});
</script>

<script>
$(document).ready(function($){
    $("#comune").autocomplete({
	source:"cerca_comuni.php"
    });
});
</script>

<script>
$(document).ready(function($){
    $("#nascita").autocomplete({
	source:"cerca_comuni.php"
    });
});
</script>

<script>
$(document).ready(function($){
    $("#provincia").autocomplete({
	source:"cerca_province.php"
    });
});
</script>

<script type="text/javascript">
$(function() {

	$('.open').click(function(event) {
	
	    var $link = $(this);
	
		var $dialog = $('<div style=\"overflow: auto;\"></div>')
				.load($link.attr('href') + ' #content')
				.dialog({
					autoOpen: false,
					title: $link.attr('title'),
					open: function(){
            var closeBtn = $('.ui-dialog-titlebar-close');
            closeBtn.append('<span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span class="ui-button-text"></span>');
        },
					width: 450,
					height: 350
					
		});
		
		$dialog.dialog('open');
	
		event.preventDefault();
	
	});

});
</script>

<style>
.box{
    display: none;
    width: 350px;
    background-color: #fff;
}

a:hover + .box,.box:hover{
    display: block;
    position: fixed;
    top: 50%;
    left: 5%;
    z-index: 100;
}
</style>

<script type="text/javascript">
function update()
	{
	document.getElementById("resto").value = document.getElementById("banconote").value-document.getElementById("tot").value;
	return;
	}
	
function updateIva()
	{
	document.getElementById("totIva").value = parseFloat(document.getElementById("prezzo").value)+((document.getElementById("prezzo").value*11)/100);
	return;
	}
function updateSconto()
	{
	document.getElementById("totSconto").value = document.getElementById("prezzoIva").value-((document.getElementById("prezzoIva").value*document.getElementById("sconto").value)/100);
	return;
	}
</script>

<script type="text/javascript" language="javascript">
function show_hide(){
  
    if(document.getElementById("contab").value == 'ct'){
      document.getElementById("prezzo_acq").style.display = 'block';
      document.getElementById("prezzo_acq_label").style.display = 'block';
    }else{
      document.getElementById("prezzo_acq").style.display = 'none';
      document.getElementById("prezzo_acq_label").style.display = 'none';
    }
}

function IsEmpty(){ 
	
	if(document.getElementById("idclientejson").value == "")
	{
		alert("Attenzione NON hai selezionato il Fornitore");
		return false;
	}else{
	return true;
	}
}

$(function () {
    var iframe = $('<iframe frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>');
    var dialog = $("<div></div>").append(iframe).appendTo("body").dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        width: "auto",
        height: "auto",
        close: function () {
            iframe.attr("src", "");
        }
    });
    $(".window-iframe").on("click", function (e) {
        e.preventDefault();
        var src = $(this).attr("href");
        var title = $(this).attr("data-title");
        var width = $(this).attr("data-width");
        var height = $(this).attr("data-height");
        iframe.attr({
            width: +width,
            height: +height,
            src: src
        });
        dialog.dialog("option", "title", title).dialog("openI");
    });
});

function sbloccaCampi() {
document.getElementById("nome").disabled = false;
document.getElementById("descr").disabled = false;
document.getElementById("prezzo").disabled = false;
document.getElementById("prezzo_acq").disabled = false;
document.getElementById("home").disabled = false;
document.getElementById("iva").disabled = false;
document.getElementById("data").disabled = false;
document.getElementById("quant").disabled = false;
document.getElementById("contab").disabled = false;
document.getElementById("mandato").disabled = false;
document.getElementById("salva").style.display = 'block';


}

function apri(url) { 
    newin = window.open(url,'titolo','scrollbars=no,resizable=yes, width=200,height=200,status=no,location=no,toolbar=no');
} 

$(function() {
		$( "#datepicker" ).datepicker();
		$( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
		$("#datepicker").datepicker("setDate", new Date());
		
		$( "#datepicker1" ).datepicker();
		$( "#datepicker1" ).datepicker( "option", "dateFormat", "mm" );
		$("#datepicker1").datepicker("setDate", new Date());
		
});

</script>


<script type="text/javascript">
var LHCChatOptions = {};
LHCChatOptions.opt = {widget_height:340,widget_width:300,popup_height:520,popup_width:500,domain:'95.110.226.234'};
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
var referrer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf('://')+1)) : '';
var location  = (document.location) ? encodeURIComponent(window.location.href.substring(window.location.protocol.length)) : '';
po.src = '//95.110.226.234/mercusa/stable/lib/livehelperchat-master/lhc_web/index.php/ita/chat/getstatus/(click)/internal/(position)/bottom_right/(ma)/br/(top)/350/(units)/pixels/(leaveamessage)/true/(department)/1/(disable_pro_active)/true?r='+referrer+'&l='+location;
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>

<script type="text/javascript" >
$(document).ready( function() {

	$( '#container' ).html( '<ul class="filetree start"><li class="wait">' + 'Generating Tree...' + '<li></ul>' );
	
	getfilelist( $('#container') , '../atleti/<?php echo $_GET['id']; ?>' );
	
	function getfilelist( cont, root ) {
	
		$( cont ).addClass( 'wait' );
			
		$.post( 'explore/Foldertree.php', { dir: root }, function( data ) {
	
			$( cont ).find( '.start' ).html( '' );
			$( cont ).removeClass( 'wait' ).append( data );
			if( '../atleti/<?php echo $_GET['id']; ?>' == root ) 
				$( cont ).find('UL:hidden').show();
			else 
				$( cont ).find('UL:hidden').slideDown({ duration: 500, easing: null });
			
		});
	}
	
	$( '#container' ).on('click', 'LI A', function() {
		var entry = $(this).parent();
		//alert( $(this).attr('rel') );
		if( entry.hasClass('folder') ) {
			if( entry.hasClass('collapsed') ) {
						
				entry.find('UL').remove();
				getfilelist( entry, escape( $(this).attr('rel') ));
				entry.removeClass('collapsed').addClass('expanded');
			}
			else {
				//alert( "No" );
				entry.find('UL').slideUp({ duration: 500, easing: null });
				entry.removeClass('expanded').addClass('collapsed');
			}
		} else {
			$( '#selected_file' ).html( "File:  <a href=\"gest_" + $(this).attr( 'rel' ) + "\" target=\"" + $(this).attr( 'rel' ) + "\">" + $(this).attr( 'rel' ) + "</a>");
		}
	return false;
	});
	
});
</script>


</head>
<body>  
	<div class="page-header">
		<div style="position: absolute; top: 10px; left: 10px;"><img src="http://95.110.226.234/gest_/img/logo.png" width="15%" height="15%" /> 
		&nbsp;&nbsp;<i><b>Societ&agrave;:</b></i> <?php echo $nome_azienda; ?>
		</div>
		<div style="text-align: right; position: absolute; float: right; left: 80%; top: 10px;">
					<span>
			Buon lavoro <b><i><?php echo $_SESSION['cod']; ?></i></b> ! 
			<a href="logout.php"><i class="glyphicon glyphicon-off"></i> Esci</a><br />
				Oggi &egrave; <b><?php echo date("d/m/Y"); ?></b>
		</span>
		</div>
	</div><br />
	
	
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<ul class="nav nav-pills">
					<li role="presentation" <?php if ($_GET['sez']==""){ echo "class=\"active\""; } ?>><a href="index.php">Inizio</a></li>
					<li role="presentation" <?php if ($_GET['sez']=="atleti"){ echo "class=\"active\""; } ?>><a href="index.php?sez=atleti">Atleti</a></li>
				</ul>
			</div>
		</div>
	</nav>
