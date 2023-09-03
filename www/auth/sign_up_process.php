<?php
require_once("../shared/connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve user input from the form
    $firstName = $_POST["InputFirstName"];
    $lastName = $_POST["InputLastName"];
    $email = $_POST["InputEmail"];
    $password = md5($_POST["InputPassword"]); // Hash the password for security

    // Check if the email is already associated with a user
    $checkEmailQuery = "SELECT UserID FROM Users WHERE Email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        $_SESSION['error_message'] = "Email is already registered. Please use a different email address.";
        header("Location: register.php");
    } else {
        $stmt->close();

        // Insert the user into the Users table
        $insertUserQuery = "INSERT INTO Users (MemberType, FirstName, LastName, Email, PasswordMD5Hash)
            VALUES (?, ?, ?, ?, ?)";
        $memberType = "Member"; // Set the member type to "Member" for a regular user

        $stmt = $conn->prepare($insertUserQuery);
        $stmt->bind_param("sssss", $memberType, $firstName, $lastName, $email, $password);

        if ($stmt->execute()) {
            $stmt->close();
            $_SESSION['user_email'] = $email;
            $_SESSION['user_type'] = $memberType;
            $_SESSION['session_expire'] = time() + 7200; // 2 hours in seconds

            header("Location: ../index.php");
        } else {
            $stmt->close();
            $_SESSION['error_message'] = "Error registering user: " . $conn->error;
            header("Location: register.php");
        }
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
