<?php
require_once("../shared/connection.php");

$dbname = "library_db";

$query = "DROP DATABASE IF EXISTS " . $dbname;
if ($conn->query($query) === TRUE) {
    echo "Database ". $dbname." dropped successfully.<br>";
}
// Create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Close the connection to create tables within the newly created database
$conn->close();

// Create tables within the database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL statements to create tables
$sql = "
CREATE TABLE IF NOT EXISTS Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    MemberType ENUM('Member', 'Admin') NOT NULL DEFAULT 'Member',
    FirstName VARCHAR(20) NOT NULL,
    LastName VARCHAR(20) NOT NULL,
    Email VARCHAR(50) NOT NULL UNIQUE,
    PasswordMD5Hash CHAR(32) NOT NULL
);

CREATE TABLE IF NOT EXISTS Books (
    BookID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(30) NOT NULL,
    Author VARCHAR(30) NOT NULL,
    Publisher VARCHAR(30) NOT NULL,
    Language ENUM('English', 'French', 'German', 'Mandarin', 'Japanese', 'Russian', 'Other') NOT NULL DEFAULT 'English',
    Category ENUM('Fiction', 'Nonfiction', 'Reference') NOT NULL DEFAULT 'Fiction',
    BorrowCount INT NOT NULL DEFAULT 0                           
);

CREATE TABLE IF NOT EXISTS BookStatus (
    StatusID INT AUTO_INCREMENT PRIMARY KEY,
    BookID INT NOT NULL,
    MemberID INT,
    Status ENUM('Available', 'Onloan', 'Deleted') NOT NULL DEFAULT 'Available',
    AppliedDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (BookID) REFERENCES Books(BookID) ON DELETE CASCADE,
    FOREIGN KEY (MemberID) REFERENCES Users(UserID)
);
";

if ($conn->multi_query($sql) === TRUE) {
    echo "Tables created successfully";
} else {
    echo "Error creating tables: " . $conn->error;
}

// Close the connection
$conn->close();
?>
