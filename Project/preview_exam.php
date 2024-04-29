<?php
$exam_file = isset($_GET['exam']) ? $_GET['exam'] : '';

// Validate and sanitize the filename (important)

$exam_folder = "generated_exams";
$exam_path = "$exam_folder/$exam_file";

if (is_file($exam_path)) {
  $exam_content = file_get_contents($exam_path);
  
  // Format the exam content for display in the modal (optional)
  
  return $exam_content; // Return the parsed content
} else {
  // Handle error: file not found
  echo "Error: Exam file not found!";
  exit;
}
?>
