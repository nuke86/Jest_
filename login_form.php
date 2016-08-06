<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Fox_Gest - Gestionale Web</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

</head>
<body>
<h1 class="alert alert-warning" align="center">ALT!! Effettua l'accesso al sistema.</h1>
<div style="position: absolute; left: 40%; width: 300px;"><h2 align="center" class="alert alert-info"><img src="http://95.110.226.234/gest_/img/logo.png" width="90%" height="90%" /></h2></div>
<div style="position: absolute; left: 40%; top: 70%; width: 300px;">
<form id="login" action="login.php" method="post">
	<fieldset id="inputs">
	    <input class="form-control" id="username" name="username" type="text" placeholder="Username" autofocus required>
	    <input class="form-control" id="password" name="password" type="password" placeholder="Password" required>
	</fieldset>
	<fieldset id="actions">
	    <button class="form-control" type="submit" id="submit"><i class="glyphicon glyphicon-play-circle"></i> Collegati</button>
	</fieldset>
</form>
</div>
</body>
</html>