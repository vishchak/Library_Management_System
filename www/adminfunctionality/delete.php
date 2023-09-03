<?php
session_start();

if (!isset($_SESSION['user_email']) || $_SESSION['user_type'] !== 'Admin') {
    header("Location: ../index.html");
    exit();
}

require_once("../shared/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $bookID = $_POST['bookID'];
    $sql = "DELETE FROM Books WHERE BookID = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the StatusID parameter
    $stmt->bind_param("i", $bookID);

    // Execute the query
    if ($stmt->execute()) {
        header("Location: admin.php");
    } else {
        // Handle the error, e.g., log or display an error message
        echo "Error deleting record: " . $conn->error;
    }

    // Close the prepared statement
    $stmt->close();
}
?>
