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

  <div class="container py-5">
    <div class="card mx-auto" style="width: 40%;">
      <div class="card-header text-center">
        <h5 class="card-title">Exam Configuration</h5>
      </div>
      <div class="card-body">
        <form action="save_exam_config.php" method="post">
          <div class="mb-3">
            <label for="num_exercises_easy" class="form-label">Number of Easy Exercises:</label>
            <input type="number" class="form-control" id="num_exercises_easy" name="num_exercises_easy" min="0" required>
          </div>
          <div class="mb-3">
            <label for="num_exercises_medium" class="form-label">Number of Medium Exercises:</label>
            <input type="number" class="form-control" id="num_exercises_medium" name="num_exercises_medium" min="0" required>
          </div>
          <div class="mb-3">
            <label for="num_exercises_hard" class="form-label">Number of Hard Exercises:</label>
            <input type="number" class="form-control" id="num_exercises_hard" name="num_exercises_hard" min="0" required>
          </div>
          <div class="mb-3">
            <label for="topics" class="form-label">Select Topics (Multiple Allowed):</label>
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
              // Fetch topic data (replace with your query)
              $sql = "SELECT DISTINCT topic
                      FROM exercice";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                echo "<select class='form-select' id='topics' name='topics[]' multiple required>";
                // Loop through topics and create options
                while ($row = $result->fetch_assoc()) {
                  $topic_id = $row['topic'];
                  echo "<option value='$topic_id'>$topic_id</option>";
                }
                echo "</select>";
              }

              $conn->close();
            ?>
          </div>
          <button type="submit" class="btn btn-primary end">Save Configuration</button>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>
</body>
</html>

