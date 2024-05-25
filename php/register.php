<?php
require_once 'db.php'; // Include your database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs (you may add more validation as needed)
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Prepare the SQL statement using parameterized query
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters to the prepared statement as strings
    $stmt->bind_param("ss", $username, $password);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Registration successful, set up session and redirect to dashboard
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $stmt->insert_id; // Get the user ID
        
        // Redirect to dashboard
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
