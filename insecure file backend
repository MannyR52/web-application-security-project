<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['id-upload'])) {
    $uploadDir = 'uploads/'; // Make sure this directory exists and is writable
    $fileTmpPath = $_FILES['id-upload']['tmp_name'];
    $fileName = basename($_FILES['id-upload']['name']);
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Only allow certain image types
    
        $safeFileName = uniqid('id_', true) . '.' . $fileExtension;
        $destination = $uploadDir . $safeFileName;

        if (move_uploaded_file($fileTmpPath, $destination)) {
            // Redirect back with success and filename
            header("Location: dashboard.php?status=success&image=" . urlencode($safeFileName));
            exit();
        
    }
}

// Redirect back with failure
header("Location: dashboard.php?status=fail");
exit();
?>
