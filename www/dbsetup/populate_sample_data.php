<?php
require_once("connection.php");

// Select the "library_db" database within the existing connection
if ($conn->select_db("library_db")) {
    // Sample Users
    $users = array(
        array("Admin", "John", "Doe", "admin@example.com", md5("adminpassword")),
        array("Member", "Alice", "Johnson", "alice@example.com", md5("alicepassword")),
        array("Member", "Bob", "Smith", "bob@example.com", md5("bobpassword"))
    );

    // Sample Books
    $books = array(
        array("Great Expectations", "Charles Dickens", "Macmillan Collectors Library", "English", "Fiction"),
        array("An Inconvenient Truth", "Al Gore", "Penguin Books", "English", "Nonfiction"),
        array("Oxford Dictionary", "Oxford Press", "Oxford Press", "English", "Reference"),
        array("Anna Karenina", "Leo Tolstoy", "Star Publishing", "Russian", "Fiction"),
        array("The Tale of Genji", "Murasaki Shikibu", "Kinokuniya", "Japanese", "Fiction")
    );

    // Insert Users into the Users table
    foreach ($users as $user) {
        $sql = "INSERT INTO Users (MemberType, FirstName, LastName, Email, PasswordMD5Hash)
            VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $user[0], $user[1], $user[2], $user[3], $user[4]);
        $stmt->execute();
        $stmt->close();
    }

    // Insert Books into the Books table
    foreach ($books as $book) {
        $sql = "INSERT INTO Books (Title, Author, Publisher, Language, Category)
            VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $book[0], $book[1], $book[2], $book[3], $book[4]);
        $stmt->execute();
        $stmt->close();
    }

    // Assign Books to Users
    $sql = "INSERT INTO BookStatus (BookID, MemberID, Status, AppliedDate)
        VALUES (?, ?, 'Onloan', NOW())";
    $stmt = $conn->prepare($sql);

    // Assign books to specific users
    $stmt->bind_param("ii", $bookID, $userID);

    $bookID = 1;
    $userID = 2;
    $stmt->execute();

    $bookID = 2;
    $userID = 3;
    $stmt->execute();

    $stmt->close();

    echo "Sample data inserted successfully.";
} else {
    echo "Database selection failed.";
}

$conn->close();
?>
