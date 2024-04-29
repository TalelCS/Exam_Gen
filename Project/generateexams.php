<?php
$nomServeur = "localhost";
$nomUtilisateur = "root";
$motdePasse = "";
$nomBD = "examgen";

$conn = new mysqli($nomServeur, $nomUtilisateur, $motdePasse, $nomBD);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$num_exams = $_POST['num_exams'];

$sql_config = "SELECT * FROM config LIMIT 1";
$result_config = $conn->query($sql_config);

if ($result_config->num_rows > 0) {
  $row_config = $result_config->fetch_assoc();
  $num_exercises_easy = $row_config['Nb_ez'];
  $num_exercises_medium = $row_config['Nb_mid'];
  $num_exercises_hard = $row_config['Nb_hard'];
  $selected_topics = json_decode($row_config['Topics']);
} else {
  echo "Error: No configuration found!";
  exit;
}

function getRandomExercises($conn, $num_exercises, $difficulty, $topics) {
    $topic_list_string = "'" . implode("','", $topics) . "'";
    $sql = "SELECT id FROM exercice WHERE Difficulty_Level = '$difficulty' AND Topic IN ($topic_list_string) ORDER BY RAND() LIMIT $num_exercises";
  
    $result = $conn->query($sql);
  
    $exercise_ids = array();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $exercise_ids[] = $row['id'];
      }
    }
  
    return $exercise_ids;
  }

  function getQuestionDetails($conn, $exercise_id) {
    $sql = "SELECT * FROM exercice WHERE id = $exercise_id";
  
    $result = $conn->query($sql);
  
    $question_data = array();
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $question_data['question_text'] = $row['Question'];
    }
  
    return $question_data;
  }
  
  

for ($i = 1; $i <= $num_exams; $i++) {
  $easy_exercises = getRandomExercises($conn, $num_exercises_easy, "1", $selected_topics);
  $medium_exercises = getRandomExercises($conn, $num_exercises_medium, "2", $selected_topics);
  $hard_exercises = getRandomExercises($conn, $num_exercises_hard, "3", $selected_topics);

  $all_exercises = array_merge($easy_exercises, $medium_exercises, $hard_exercises);
  shuffle($all_exercises);

  
  $exam_content = "";

  $exam_content .= "Exam Instructions\n\n";
  $exam_content .= "These are the instructions for the exam...\n\n";
  
  $exam_content .= "**Questions**\n\n";
  $j = 0;
  foreach ($all_exercises as $exercise_id) {
    $question_data = getQuestionDetails($conn, $exercise_id);
    $exam_content .= "Question " . ($j + 1) . ":\n";
    $exam_content .= $question_data['question_text'] . "\n";
    $exam_content .= "-----\n";
    $j++;
  }

  // Write exam content to a file with a unique name (e.g., exam_$i.txt)
  $filename = "generated_exams/exam_" . $i . ".txt";
  $file = fopen($filename, "w") or die("Unable to open file!");
  fwrite($file, $exam_content);
  fclose($file);

  echo "Exam " . $i . " generated successfully!_n";
}

$conn->close();
?>
