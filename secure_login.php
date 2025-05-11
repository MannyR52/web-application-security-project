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
    $sql = "SELECT id, username, password FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);

    // If login is successful
    if ($stmt) {
        $stmt->bind_param("ss", $username, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user'] = $user['username'];
            // $_SESSION['user_name'] = $user['name']; // If you have a 'name' column
            header('Location: banking_dashboard.php');
            exit();
        } else {
            echo "<h3 style='color:red;'>Invalid login. Please try again.</h3>";
            echo "<a href='login_form.php'>Go back to Login</a>";
        }
        $stmt->close();
    } else {
        die("Error preparing SQL statement: " . $conn->error);
    }
}

$conn->close();
?>
