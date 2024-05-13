<?php
$error_message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $matric_number = $_POST['matric_number'];
    $username = $_POST['username'];

    // Load matric numbers from JSON file
    $matric_numbers_json = file_get_contents('matric_numbers.json');
    $matric_numbers_array = json_decode($matric_numbers_json, true);

    // Check if matric number exists in the JSON array
    if (in_array($matric_number, $matric_numbers_array['matric_Numbers'])) {
        // Matric number found in JSON file
        // Proceed with registration

        // Connect to MySQL database
        $servername = "localhost";
        $username_db = "root";
        $password_db = "";
        $dbname = "nacos-vote";

        $conn = new mysqli($servername, $username_db, $password_db, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if matric number already exists in the database
        $sql = "SELECT * FROM users WHERE matric_number='$matric_number'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Matric number already exists
            $error_message = "Matric number already registered.";
        } else {
            // Insert new user into the database
            $sql = "INSERT INTO users (matric_number, username) VALUES ('$matric_number', '$username')";

            if ($conn->query($sql) === TRUE) {
                // Redirect to verification page
                header("Location: voting_page.php");
                exit();
            } else {
                $error_message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
    } else {
        // Matric number not found in JSON file
        $error_message = "Invalid matric number.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NACOS VOTTING SYSTEM</title>
  <link rel="stylesheet" href="CSS/verify.css">
  <link rel="shortcut icon" href="nacos-logo2.png" type="image/x-icon">
  <script src="https://unpkg.com/scrollreveal"></script>
  <script src="https://unpkg.com/scrollreveal@4"></script>
  <script>
    ScrollReveal({
      duration: 1000
    })
  </script>
</head>

<body>
  <div class="container">
    <img src="nacos-logo2.png" alt="" class="headline">
    <h2 class="txt tagline">Register For The Election</h2>
    <form  class="punchline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <label for="name">Name</label>
      <input type="text" name="username" id="" placeholder="Enter Your Name" required>
      <label for="matric">Matric Number</label>
      <input type="text" id="matricNumber" name="matric_number" placeholder="Enter Matriculation Number" required>
      <button type="submit" id="verify">Continue</button>
      <div style="color: red;"><?php echo $error_message; ?></div>
    </form>
  </div>
  <script src="JS/verify.js"></script>
</body>

</html>