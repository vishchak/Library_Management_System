<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['user_email']) || $_SESSION['user_type'] !== 'Admin') {
    header("Location: ../auth/login.php");
    exit();
}

require_once("../shared/connection.php");

// Retrieve the Book ID from the URL parameter
if (isset($_GET['bookID'])) {
    $bookID = $_GET['bookID'];

    // Query to retrieve book details by Book ID
    $query = "SELECT * FROM Books WHERE BookID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $bookID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Fetch book details
        $book = $result->fetch_assoc();
        // Close the prepared statement
        $stmt->close();
    } else {
        // Book not found
        echo "Book not found.";
        exit();
    }
} else {
    // Book ID not provided in the URL
    echo "Book ID is required.";
    exit();
}

// Handle form submission to update book details
if (isset($_POST['updateBook'])) {
    $updatedTitle = $_POST['title'];
    $updatedAuthor = $_POST['author'];
    $updatedPublisher = $_POST['publisher'];
    $updatedLanguage = $_POST['language'];
    $updatedCategory = $_POST['category'];

    // Query to update the book details
    $updateQuery = "UPDATE Books SET Title = ?, Author = ?, Publisher = ?, Language = ?, Category = ? WHERE BookID = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssssi", $updatedTitle, $updatedAuthor, $updatedPublisher, $updatedLanguage, $updatedCategory, $bookID);

    if ($stmt->execute()) {
        // Book updated successfully
        header("Location: admin.php"); // Redirect to the admin page
    } else {
        // Handle the error, e.g., log or display an error message
        echo "Error updating book: " . $conn->error;
    }

    // Close the prepared statement
    $stmt->close();
}
?>

<!DOCTYPE html>
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

    <title>Edit Book Details</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="about.html">About <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">Contact</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<div class="container mx-auto">

    <div class="container">
        <h1 class="text-center display-4">Edit book details</h1>
    </div>

    <form method="post" action="">
        <!-- Hidden input to store the Book ID for updating -->
        <input type="hidden" name="bookID" value="<?php echo $book['BookID']; ?>">

        <!-- Form fields for editing book details -->
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" name="title" id="title" value="<?php echo $book['Title']; ?>">
        </div>

        <div class="form-group">
            <label for="author">Author:</label>
            <input type="text" class="form-control" name="author" id="author" value="<?php echo $book['Author']; ?>">
        </div>

        <div class="form-group">
            <label for="publisher">Publisher:</label>
            <input type="text" class="form-control" name="publisher" id="publisher"
                   value="<?php echo $book['Publisher']; ?>">
        </div>

        <div class="form-group">
            <label for="language">Language:</label>
            <select class="form-control" name="language" id="language">
                <option value="<?php echo $book['Language']; ?>"><?php echo $book['Language']; ?></option>
                <option value="English">English</option>
                <option value="French">French</option>
                <option value="German">German</option>
                <option value="Mandarin">Mandarin</option>
                <option value="Japanese">Japanese</option>
                <option value="Russian">Russian</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="category">Category:</label>
            <select class="form-control" name="category" id="category">
                <option value="<?php echo $book['Category']; ?>"><?php echo $book['Category']; ?></option>
                <option value="Fiction">Fiction</option>
                <option value="Nonfiction">Nonfiction</option>
                <option value="Reference">Reference</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" name="updateBook">Update Book</button>
    </form>
</div>

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
