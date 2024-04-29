<?php
$nomServeur = "localhost";
$nomUtilisateur = "root";
$motdePasse = "";
$nomBD = "examgen";

$conn = new mysqli($nomServeur, $nomUtilisateur, $motdePasse, $nomBD);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$num_exercises_easy = $_POST['num_exercises_easy'];
$num_exercises_medium = $_POST['num_exercises_medium'];
$num_exercises_hard = $_POST['num_exercises_hard'];

$selected_topics = json_encode($_POST['topics']);

$sql = "UPDATE config SET Nb_hard = " . $num_exercises_hard . ", Nb_mid = " . $num_exercises_medium . ", Nb_ez = " . $num_exercises_easy . ", Topics = '" . $selected_topics . "' WHERE 1";

if ($conn->query($sql) === TRUE) {
  echo "Configuration updated successfully!";
} else {
  echo "Error updating configuration: " . $conn->error;
}

$conn->close();
?>
