<?php
$error_message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $matric = $_POST['matric'];
    $president = $_POST['president']; 
    $vicePresident = $_POST['vicePresident'];

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

    // Check if matric number exists in the database
    $sql_check_user = "SELECT * FROM users WHERE matric_number='$matric'";
    $result_check_user = $conn->query($sql_check_user);

    if ($result_check_user->num_rows > 0) {
        // Matric number found in users table
        // Check if the user has already cast a vote
        $sql_check_vote = "SELECT * FROM votes WHERE matric='$matric'";
        $result_check_vote = $conn->query($sql_check_vote);

        if ($result_check_vote->num_rows > 0) {
            // User has already casted a vote
            $error_message = "You've already casted a vote.";
        } else {
            // User hasn't casted a vote yet, proceed with storing the vote
            // Insert data into votes table
            $sql_insert_vote = "INSERT INTO votes (matric, president, vicePresident) VALUES ('$matric', '$president', '$vicePresident')";

            if ($conn->query($sql_insert_vote) === TRUE) {
                // Redirect to success page
                header("Location: success-page.html");
                exit();
            } else {
                $error_message = "Error: " . $sql_insert_vote . "<br>" . $conn->error;
            }
        }
    } else {
        // Matric number not found in users table
        $error_message = "Matric number not registered.";
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting page</title>
    <link rel="shortcut icon" href="nacos-logo2.png" type="image/x-icon">
    <link rel="stylesheet" href="CSS/vote.css">
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://unpkg.com/scrollreveal@4"></script>
    <script>
        ScrollReveal({
            duration: 1000
        })
    </script>
</head>

<body>
    
    <div class="intro ">
        <img src="nacos-logo2.png" alt="" class="headline">
        <h1 class="tagline">Make Your Voice Heard!Together,
            let's create a brighter Crawford. Cast your vote now!"</h1>
    </div>

    <div class="error-message" style="background-color: #ffdddd; border-left: 6px solid #f44336;  margin-bottom: 15px; "><p><strong><?php echo $error_message; ?></strong> </p></div>


    <section class="punchline">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="question punchline">
                <label for="matric"><b>Matric Number:</b></label>
                <input type="number" name="matric" id="" required placeholder="Enter Matric number" style="padding: 5px;border: 2px solid black; outline: none; border-radius:5px;">
            </div>
            <ol>
                <div class="question punchline">
                    <li class="question-card">
                        <b>NACOS President</b>
                        <div class="options">
                            <label class="option" for="president">
                                <input type="radio" name="president" id="option1" value="option1" required>
                                Option 1
                            </label>

                            <label class="option" for="president">
                                <input type="radio" name="president" id="Ebhu" value="option2">
                                option 2
                            </label>
                        </div>

                    </li>
                </div>

                <div class="question punchline">
                    <li class="question-card">
                        <b>NACOS Vice-President</b>
                        <div class="options">
                            <label class="option" for="vicePresident">
                                <input type="radio" name="vicePresident" id="option2" value="option1" required>

                                option 1
                            </label>

                            <label class="option" for="vicePresident">
                                <input type="radio" name="vicePresident" id="option2" value="option2">

                                Option 2
                            </label>
                        </div>

                    </li>
                </div>
            </ol>
            <button type="submit" style=" color: white; border-radius: 7px; padding: 15px; background-color: rgb(96, 247, 96); width: 200px; border:none; font-size:20px;">Submit</button>
        </form>
    </section>

    <script src="JS/verify.js"></script>
</body>

</html>