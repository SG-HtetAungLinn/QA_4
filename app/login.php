<?php
session_start();
header('Content-Type: application/json');
$userFileName = "../data/users.json";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";
    if (empty($username) || empty($password)) {
        echo json_encode([
            "success" => "error",
            "message" => "Username and password required"
        ]);
        exit;
    }
    // check file is exists
    if (!file_exists($userFileName)) {
        echo json_encode([
            "success" => "error",
            "message" => "User data not found"
        ]);
        exit;
    }
    // take data from json file
    $jsonData = file_get_contents($userFileName);
    $users = json_decode($jsonData, true);

    // Check if users is an array
    if (!is_array($users)) {
        echo json_encode([
            "success" => false,
            "message" => "User data is corrupted"
        ]);
        exit;
    }

    // Search for matching user
    foreach ($users['users'] as $user) {
        if ($user["username"] === $username && $user["password"] === $password) {
            $_SESSION["user"] = [
                "username" => $user["username"],
                "role" => $user["role"] ?? 'student'
            ];

            echo json_encode([
                "success" => true,
                "role" => $user["role"] ?? 'student'
            ]);
            exit;
        }
    }

    // No matching user found
    echo json_encode([
        "success" => false,
        "message" => "Username or password is wrong!"
    ]);
    exit;
}
