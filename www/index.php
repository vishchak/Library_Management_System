<?php

session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_email']) || empty($_SESSION['user_email'])) {
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

    <link rel="stylesheet" href="custom.css">


    <title>Home - Library Management System</title>
</head>
<body>
<div class="text-center text-lg-center" style="background-color:#181725; color: #fefefe">
    <!-- Header -->
    <div class="row">
        <div class="col">
            <img src="images/logo.jpg" alt="Logo" width="150">
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
                <li class="nav-item active">
                    <a class="nav-link" href="browse_borrow.php">Catalog <span class="sr-only">(current)</span></a>
                </li>
                <?php
                // Check if the user is an admin (MemberType equals "Admin")
                if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'Admin') {
                    echo '<li class="nav-item"><a class="nav-link" href="../adminfunctionality/admin.php">Admin</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</div>

<div class="container mx-auto">
    <div class="container">
        <header class="text-center mt-5">
            <h1>Your Gateway to a World of Knowledge</h1>
        </header>

        <section class="mt-5">
            <h2>About Our Library</h2>
            <p>
                At out library, we believe in the power of books to transform lives. Our library is a haven for book
                lovers, providing access to an extensive collection of literature from various genres, languages, and
                categories. We are committed to promoting literacy, learning, and the joy of reading in our community.
            </p>
        </section>

        <hr class="my-5 bg-info">


        <div class="container">
            <h2 class="text-center display-4">Our most popular book</h2>
        </div>

        <div class="book-list">
            <?php
            require_once("shared/connection.php"); // Include your database connection script

            // Step 1: Query the database to fetch books with the highest BorrowCount
            $getHighestBorrowedBooksQuery = "SELECT * FROM Books WHERE BorrowCount = (SELECT MAX(BorrowCount) FROM Books)";
            $result = $conn->query($getHighestBorrowedBooksQuery);

            if ($result->num_rows > 0) {
                // Step 2: Randomly select one of the books if there are multiple
                $highestBorrowedBooks = [];
                while ($row = $result->fetch_assoc()) {
                    $highestBorrowedBooks[] = $row;
                }

                $selectedBook = $highestBorrowedBooks[array_rand($highestBorrowedBooks)];

                // Loop through the fetched book data and generate HTML for each book
                echo '<div class="row book-card mb-4">';
                echo '<div class="col-md-4">';
                echo '<div class="d-flex flex-column h-100">';

                echo '<img src="images/book_' . $selectedBook['BookID'] . '.png" alt="Book Cover" class="img-fluid flex-grow-1">';

                echo '</div>';
                echo '</div>';

                echo '<div class="col-md-8">';
                echo '<div class="d-flex flex-column h-100">';

                echo '<h3>' . $selectedBook['Title'] . '</h3>';
                echo '<p>Author: ' . $selectedBook['Author'] . '</p>';
                echo '<p>Publisher: ' . $selectedBook['Publisher'] . '</p>';
                echo '<p>Language: ' . $selectedBook['Language'] . '</p>';
                echo '<p>Category: ' . $selectedBook['Category'] . '</p>';

                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            ?>
        </div>

        <hr class="my-5 bg-info">

        <section class="mt-5">
            <h2>Interesting Facts About Books</h2>
            <p>
                <strong>1. The Oldest Surviving Book:</strong> The oldest surviving book is believed to be the Diamond
                Sutra, a Buddhist text printed in China in 868 AD. It's a testament to the enduring nature of books.
            </p>
            <p>
                <strong>2. Largest Library:</strong> The Library of Congress in Washington, D.C., is the largest library
                in the world, housing over 170 million items. It's a treasure trove of knowledge.
            </p>
            <p>
                <strong>3. The Longest Novel:</strong> "Artamène ou le Grand Cyrus" by Madeleine de Scudéry is
                considered the longest novel ever written. It contains over 2 million words and is a literary
                masterpiece.
            </p>
        </section>
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
