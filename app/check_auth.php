<?php
session_start();
$authentication = false;
if (isset($_SESSION['user'])) {
    $authentication = true;
    if ($_SERVER['REQUEST_URI'] == '/QA_4/login.php') {
        header("Refresh: 0; url=index.php");
        exit();
    }
}

if (!$authentication) {
    header("Refresh: 0; url=logout.php");
    exit();
}
