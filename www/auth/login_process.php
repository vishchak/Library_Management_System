<?php
session_start();

require_once("../shared/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve user input from the login form
    $email = $_POST["inputEmail"];
    $password = md5($_POST["inputPassword"]);

    // Query to check if the email and password match a user in the database
    $checkLoginQuery = "SELECT UserID, MemberType FROM Users WHERE Email = ? AND PasswordMD5Hash = ?";
    $stmt = $conn->prepare($checkLoginQuery);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Login successful, retrieve user details
        $stmt->bind_result($userID, $memberType);
        $stmt->fetch();

        // Set up user session variables
        $_SESSION['user_email'] = $email;
        $_SESSION['user_id'] = $userID;
        $_SESSION['user_type'] = $memberType;
        $_SESSION['session_expire'] = time() + 7200; // 2 hours in seconds

        // Redirect to home page
        header("Location: ../index.php");
    } else {
        // Invalid login credentials
        $_SESSION['error_message'] = "Invalid email or password. Please try again.";
        header("Location: login.php"); // Redirect back to the login page with an error message
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to the login page if the request method is not POST
    header("Location: login.php");
}
?>
