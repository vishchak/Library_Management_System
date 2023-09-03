<?php

session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_email']) || empty($_SESSION['user_email']) || $_SESSION['user_type'] !== 'Admin') {
    header("Location: ../auth/login.php");
    exit();
} ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap CSS and JavaScript -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../custom.css">


    <title>Admin - Library Management System</title>
</head>
<body>
<div class="text-center text-lg-center" style="background-color:#181725; color: #fefefe">
    <!-- Header -->
    <div class="row">
        <div class="col">
            <img src="../images/logo.jpg" alt="Logo" width="150">
            <h1>Australian University Library</h1>
        </div>
    </div>
</div>

<div class="container" style="margin: 20px auto">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.html">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../userfunctionality/browse_borrow.php">Catalog</span></a>
                </li>

                <li class="nav-item active"><a class="nav-link" href="admin.php">Admin <span
                                class="sr-only">(current)</span></a></li>
            </ul>
        </div>
    </nav>
</div>

<div class="container mx-auto">

    <div class="container">
        <h2 class="text-center display-4">Edit, Return and Delete Books</h2>
    </div>

    <div class="book-list">
        <?php
        require_once('../shared/connection.php');

        $query = "SELECT Books.*, BookStatus.Status, BookStatus.AppliedDate
          FROM Books
          LEFT JOIN BookStatus ON Books.BookID = BookStatus.BookID";
        // Execute the query and fetch book data
        $result = $conn->query($query);

        // Loop through the fetched book data and generate HTML for each book
        while ($book = $result->fetch_assoc()) {
            echo '<div class="row book-card mb-4">';
            echo '<div class="col-md-4">';
            echo '<div class="d-flex flex-column h-100">';

            echo '<img src="../images/book_' . $book['BookID'] . '.png" alt="Book Cover" class="img-fluid flex-grow-1">';

            echo '</div>';
            echo '</div>';

            echo '<div class="col-md-8">';
            echo '<div class="d-flex flex-column h-100">';

            echo '<h3>' . $book['Title'] . '</h3>';
            echo '<p>Author: ' . $book['Author'] . '</p>';
            echo '<p>Publisher: ' . $book['Publisher'] . '</p>';
            echo '<p>Language: ' . $book['Language'] . '</p>';
            echo '<p>Category: ' . $book['Category'] . '</p>';

            if ($book['Status'] !== 'Onloan') {
                echo '<button class="btn btn-secondary mt-auto" disabled>Return</button>';
            } else {
                echo '<p>Borrowed Date: ' . $book['AppliedDate'] . '</p>';
                echo '<div class="mt-auto">';
                echo '<form method="post" action="return.php" class="d-flex" >';
                echo '<input type="hidden" name="bookID" value="' . $book['BookID'] . '">';
                echo '<button class="btn btn-primary" type="submit" >Return</button>';
                echo '</form>';
                echo '</div>';
            }

            echo '<div class="mt-auto">';
            echo '<a href="edit.php?bookID=' . $book['BookID'] . '" class="btn btn-info">Edit</a>';
            echo '</div>';

            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        ?>
    </div>
</div>

<!-- Footer -->
<footer class="text-white text-center"
        style="background-color: #434152; color: #fefefe; margin: 20px auto 0; padding: 20px 0 0">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <ul class="list-unstyled">
                    <li><a href="terms_and_conditions.html">Terms of Service</a></li>
                    <li><a href="faq.html">FAQs</a></li>
                    <li><a href="help.html">Help Center</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-6">
                <ul class="list-unstyled">
                    <li><a href="https://www.facebook.com/breedableboy/">Facebook</a></li>
                    <li><a href="https://www.instagram.com/breedable.boy/">Instagram</a></li>
                    <li><a href="https://www.linkedin.com/vishchak/">LinkedIn</a></li>
                </ul>
            </div>
            <div class="col-lg-4 d-flex justify-content-center align-items-center">
                <p>&copy; 2023 Australian library. All Rights Reserved.</p>
            </div>

        </div>
    </div>
</footer>
</body>
</html>
