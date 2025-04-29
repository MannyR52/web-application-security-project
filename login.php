<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Basic PHP login script made to be intentionally vulnerable
//      - Uses unsalted MD5 hashes and unparametrized SQL


session_start();

// Simple DB connection w/ no error handling
$servername = "localhost";
$username = "root";
$password = "52";
$dbname = "bankapp";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check DB connection
if ($conn->connect_error) {
    die("Connection has failed: ". $conn->connect_error);
}



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    // Capture POST data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // MD5 hash pass (vulnerable, but as per your request)
    $hashedPassword = md5($password);

    // Unsecure SQL query (vulnerable)
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$hashedPassword'";

    $result = $conn->query($sql);

    // If login is successful
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Set session variables
        $_SESSION['user'] = $email;
        $_SESSION['user_name'] = $user['name']; // fetch the user's name if you have 'name' in your table

        // Redirect to dashboard
        header('Location: banking_dashboard.php');
        exit();
    } else {
        echo "<h3 style='color:red;'>Invalid login. Please try again.</h3>";
        echo "<a href='login_form.php'>Go back to Login</a>";
    }
}

$conn->close();
?>
