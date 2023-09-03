<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once("../shared/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bookID = $_POST['bookID'];
    $userID = $_SESSION['user_id'];

    // Check if the book is available (status is not "Onloan")
    $checkBookQuery = "SELECT Status FROM BookStatus WHERE BookID = ?";
    $stmt = $conn->prepare($checkBookQuery);
    $stmt->bind_param("i", $bookID);
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();

    if ($status !== 'Onloan') {
        // Borrow the book by updating its status
        $borrowBookQuery = "INSERT INTO BookStatus (BookID, MemberID, Status, AppliedDate)
            VALUES (?, ?, 'Onloan', NOW())";
        $stmt = $conn->prepare($borrowBookQuery);
        $stmt->bind_param("ii", $bookID, $userID);

        if ($stmt->execute()) {
            $updateBorrowCountQuery = "UPDATE Books SET BorrowCount = BorrowCount + 1 WHERE BookID = ?";
            $stmt = $conn->prepare($updateBorrowCountQuery);
            $stmt->bind_param("i", $bookID);
            $stmt->execute();

            header("Location: ../userfunctionality/browse_borrow.php");
            exit();
        } else {
            echo "Error borrowing book: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "The book is already on loan.";
    }
} else {
    header("Location: ../userfunctionality/browse_borrow.php");
}

$conn->close();
?>
