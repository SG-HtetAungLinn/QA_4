<?php
session_start();
if (isset($_SESSION['user'])) {
    require_once './app/check_auth.php';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100 ">
        <div class="card p-5" style="border-radius:20px; box-shadow:3px 3px 3px black;">
            <div class="row">
                <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center">
                    <img src="./img/login.avif" alt="Illustration" class="img-fluid">
                </div>
                <div class="col-12 col-md-6">
                    <h2 class="fw-bold mb-4 text-center mt-5">Sign in</h2>
                    <div class="alert alert-danger" id="errorMsg" style="display:none;">
                    </div>
                    <form method="POST" id="login_form">
                        <div class="mb-4">
                            <input type="text" name="username" class="form-control" placeholder="Enter username" id="username" />
                            <small class="text-danger" id="username-error"></small>
                        </div>
                        <div class="mb-4">
                            <input type="password" name="password" class="form-control" placeholder="Enter Password" id="password" />
                            <small class="text-danger" id="password-error"></small>
                        </div>
                        <div class="d-grid my-5">
                            <button type="submit" class="btn btn-primary">Log in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/login.js"></script>
</body>

</html>