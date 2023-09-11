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


    <title>Sign in - Library Management System</title>

    <script>
        <?php
        session_start();
        if (isset($_SESSION['error_message'])) {
            echo "alert('" . $_SESSION['error_message'] . "');";
            unset($_SESSION['error_message']);
        }
        ?>
    </script>
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
        <a class="navbar-brand" href="../index.php">Home</a>
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
        <h1 class="text-center display-4">Sign in</h1>
    </div>

    <form action="login_process.php" method="POST" onsubmit="return validateForm()" novalidate>
        <div class="form-group">
            <label for="inputEmail">Email address</label>
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" required>
        </div>
        <div class="form-group">
            <label for="inputPassword">Password</label>
            <input type="password" class="form-control" id="inputPassword" name="inputPassword" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <p id="sing-in">Don't have an account? <a href="register.php">Sign up</a></p>

    <!-- JavaScript for custom form validation -->
    <script>
        function validateForm() {
            var email = document.getElementById("inputEmail").value;
            var password = document.getElementById("inputPassword").value;

            if (email === "" || password === "" || email.isEmpty() || password.isEmpty()) {
                alert("All the fields must me filled in");
                return false;
            }
            return true;
        }
    </script>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let referrer = document.referrer;
        if (referrer.endsWith("/login_process.php")) {
            alert("Invalid credentials");
        }
    });
</script>

</body>
</html>
