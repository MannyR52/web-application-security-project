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



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    // Capture POST data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // MD5 hash pass (vulnerable)
    $hashedPassword = md5($password);

    // Unsecure SQL query (vulnerable to SQL injection ' OR 1=1 --)
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$hashedPassword'";

    $result = $conn->query($sql);

    // If login is successful
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Set session variables
        $_SESSION['user'] = $username;
        $_SESSION['user_name'] = $user['name']; // fetch the user's name if 'name' in table

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
