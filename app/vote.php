<?php
require './common.php';
require './check_auth.php';

header('Content-Type: application/json');

if (!isset($_POST['question_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Question ID is required'
    ]);
    exit;
}

$questionId = $_POST['question_id'];
$username = $_SESSION['user']['username'];

$result = addVote($questionId, $username);

echo json_encode([
    'success' => true,
    'message' => 'Vote updated successfully'
]);
exit;
