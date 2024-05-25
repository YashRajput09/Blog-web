<?php
require_once 'db.php'; // Include your database connection

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $title = htmlspecialchars($_POST["title"]);
    $content = htmlspecialchars($_POST["content"]);
    $user_id = $_SESSION['user_id']; // Get user ID from session

    // Prepare the SQL statement using parameterized query
    $sql = "INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters to the prepared statement as strings
    $stmt->bind_param("iss", $user_id, $title, $content);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Post inserted successfully, redirect to dashboard
        header("Location: ../dashboard.html");
        exit();
    } else {
        // Error in SQL execution
        echo "Error: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
