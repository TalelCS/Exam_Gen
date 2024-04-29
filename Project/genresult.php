<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
    <div class="container-fluid">
      <button
        data-mdb-collapse-init
        class="navbar-toggler"
        type="button"
        data-mdb-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <i class="fas fa-bars"></i>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <a class="navbar-brand mt-2 mt-lg-0" href="#">
          <img
            src="logo.png"
            height="15"
            alt="MDB Logo"
            loading="lazy"
          />
        </a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Exercices</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="config.php">Exam Configuration</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="genresult.php">Generation Result</a>
          </li>
        </ul>
        </div>
      </div>
    </nav>
    <div class="container">
        <button type="button" class="btn btn-primary float-end" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#uploadModal">
            Generate Exams
        </button>

        <h1 class="text-center mt-4">Generated Exams</h1>
        <div class class="container">
      <?php
      $exam_folder = "generated_exams";

      if (is_dir($exam_folder)) {
        $exams = scandir($exam_folder); // Get list of files

        // Remove unnecessary entries (".", "..")
        unset($exams[0], $exams[1]);

        echo "<table class='table table-hover'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th scope='col' style='text-align: center;'>Exam Name</th>"; // Center header text
        echo "<th scope='col' style='text-align: center;'>Actions</th>"; // Left-align header text
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($exams as $exam_file) {
          $exam_name = str_replace(".txt", "", $exam_file); // Extract exam name (without .txt)

          echo "<tr>";
          echo "<td>$exam_name</td>";
          echo "<td style='text-align: right'>";
          echo "<a href='preview_exam.php?exam=$exam_file' class='btn btn-secondary btn-sm mx-2 my-2'>Preview</a>"; // Yellow button
          echo "<a href='edit_exam.php?exam=$exam_file' class='btn btn-secondary btn-sm mx-2 my-2'>Edit</a>"; // Yellow button
          echo "<a href='download_exam.php?exam=$exam_file' class='btn btn-primary btn-sm mx-2 my-2'>Download PDF</a>"; // Blue button
          echo "</td>";
          echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";

      } else {
        echo "No generated exams found!";
      }
      ?>

    </div>
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg"> <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Exam Preview: <span id="preview-exam-name"></span></h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="preview-content">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

        
        
      <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Generate Exams</h5>
              <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="generateexams.php" method="post">
      
              <label class="form-label" for="customRange1">Choose the number of exams you want to generate</label>
                <div class="range" data-mdb-range-init>
                <input type="range" class="form-range" min="1" max="50" id="customRange1" name="num_exams" />
                </div>

                <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Close</button>
                <button type="submit" value="Upload"  class="btn btn-primary" data-mdb-ripple-init>Start Generating</button>
      
              </form>
            </div>
          </div>
        </div>
      </div>
      
<!-- MDB -->
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"
></script>
<script>
    import * as mdb from 'mdb-ui-kit'; // lib
    window.mdb = mdb;
</script>

<?php
// Check for message and alert type in URL parameters
$message = isset($_GET['message']) ? urldecode($_GET['message']) : '';
$alert_type = isset($_GET['alert_type']) ? $_GET['alert_type'] : '';
?>

<?php if ($message): ?>
  <div class="alert alert-<?php echo $alert_type; ?>">
    <?php echo $message; ?>
  </div>
<?php endif; ?>

    
</body>
</html>