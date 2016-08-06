<?php
// questo file effettua ricerche in tempo reale per completare le caselle di testo quando viene richiesto un articolo
include 'config.php';

try {
  $conn = new PDO("mysql:host=$mysql_ip;dbname=$db_name", $db_user, $db_pass);
} catch(PDOException $e) {
  echo $e->getMessage();
}
$cmd = 'SELECT * FROM comuni WHERE nome LIKE :term ORDER BY nome';


$term = $_GET['term'] . "%";

$result = $conn->prepare($cmd);
$result->bindValue(":term", $term);
$result->execute();
$arrayArticoli = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$nome = $row['nome'];
	$str = mb_convert_encoding($nome, "UTF-8");
	$rowArray['label'] = $str;
	$rowArray['value'] = $str;
	array_push($arrayArticoli, $rowArray);
	

}
$conn = NULL;

echo json_encode($arrayArticoli);
?>
