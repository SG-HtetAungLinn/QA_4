<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'QA Project' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/style.css" />
    <script src="../js/jquery/jquery.min.js" type="text/javascript"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark text-success shadow sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php">
                <img src="./img/logo.png" alt="Logo" height="50" class="d-inline-block align-top rounded-5">
            </a>
            <button class="navbar-toggler text-light bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="logout.php">Logout</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <?php if (isset($_SESSION['user'])) { ?>
                        <span class="me-3 small text-white">
                            <?= $_SESSION['user']['username'] ?? '' ?>
                            <span class="badge bg-info ms-2 p-1"><?= $_SESSION['user']['role'] ?? '' ?></span>
                        </span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>