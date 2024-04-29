<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Font Awesome -->
<link
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
rel="stylesheet"
/>
<!-- Google Fonts -->
<link
href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
rel="stylesheet"
/>
<!-- MDB -->
<link
href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css"
rel="stylesheet"
/>
</head>
<body>
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
    <!-- Container wrapper -->
    <div class="container-fluid">
      <!-- Toggle button -->
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
  
      <!-- Collapsible wrapper -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Navbar brand -->
        <a class="navbar-brand mt-2 mt-lg-0" href="#">
          <img
            src="logo.png"
            height="15"
            alt="MDB Logo"
            loading="lazy"
          />
        </a>
        <!-- Left links -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Exercices</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="config.php">Exam Configuration</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="genresult.php">Generation Result</a>
          </li>
        </ul>
        <!-- Left links -->
      </div>
      <!-- Collapsible wrapper -->
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->
      <div class="container">
        <button type="button" class="btn btn-primary float-end" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#uploadModal">
            Upload Exercise
        </button>

        <h2 class="text-center mb-4">Exercices</h2>
      
        <div id="exercise-list" class="row">
        <?php
        // Connect to database (replace details with yours)
        $nomServeur = "localhost";
        $nomUtilisateur = "root";
        $motdePasse = "";
        $nomBD = "examgen";

        $conn = new mysqli($nomServeur, $nomUtilisateur, $motdePasse, $nomBD);

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // Fetch exercise data (replace with your query if needed)
        $sql = "SELECT * FROM exercice";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // Loop through exercises and display in cards
          while ($row = $result->fetch_assoc()) {
            $question_text = $row['Question'];
            $difficulty_level = $row['Difficulty_Level'];
            $topic = $row['Topic'];

            // Create card content
            $card_content = "
            <div class='col-md-4 mb-3'>
              <div class='card mb-3'>
                <div class='card-body'>
                  <h5 class='card-title'>Question : $question_text</h5>
                  <p class='card-text'>Difficulty: $difficulty_level, Topic: $topic</p>
                <a href='edit_exercise.php?id=<?php echo $row[ID]; ?>' class='btn btn-sm btn-info'>Edit</a>
                <a href='#' class='btn btn-sm btn-danger' onclick='deleteExercise(<?php echo $row[ID]; ?>)'>Delete</a>
              </div>
            </div>
            </div>
            ";

            // Add card content to exercise list
            echo $card_content;
          }
        } else {
          echo "<p class='text-center'>No exercises found.</p>";
        }

        $conn->close();
      ?>
        </div>
      </div>
    
      <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Upload Exercise</h5>
              <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="/project/upload_exercice.php" method="post">
      
                <label for="question_text">Question Text:</label><br>
                <textarea id="question_text" name="question_text" rows="5" cols="50" required></textarea><br><br>
      
                <label for="difficulty_level">Difficulty Level:</label><br>
                <select id="difficulty_level" name="difficulty_level" required>
                  <option value="1">Easy</option>
                  <option value="2">Medium</option>
                  <option value="3">Hard</option>
                </select><br><br>
      
                <label for="topic">Topic:</label><br>
                <input type="text" id="topic" name="topic" required><br><br>

                <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">Close</button>
                <button type="submit" value="Upload"  class="btn btn-primary" data-mdb-ripple-init>Save Exercise</button>
      
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