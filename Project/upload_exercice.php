<?php
$nomServeur = "localhost";
$nomUtilisateur = "root";
$motdePasse = "";
$nomBD = "examgen";

$question_text = $_POST["question_text"];
$difficulty_level = $_POST["difficulty_level"];
$topic = $_POST["topic"];

$conn = new mysqli($nomServeur, $nomUtilisateur, $motdePasse, $nomBD);

if ($conn -> connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO `exercice` (`ID`, `Question`, `Difficulty_Level`, `Topic`) VALUES (NULL, '$question_text', '$difficulty_level', '$topic');";

if ($conn -> query($sql) === True) {
  $message = "l'ajout a été effectué avec succès";
  $alert_type = "success";
} else {
  $message = "Erreur:" .$sql. "<br>". $conn->error;
  $alert_type = "danger";
}

$conn->close();

// Redirect to index.html with message (using header)
header('Location: index.php?message=' . urlencode($message) . '&alert_type=' . $alert_type);

?>
