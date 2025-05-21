<?php
require './common.php';
require './check_auth.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit;
}

$question_id = $_POST['question_id'] ?? '';
$module = $_POST['module'] ?? '';
$answer = $_POST['answer'] ?? '';

// Validate input
if (empty($question_id)) {
    echo json_encode([
        'success' => false,
        'message' => 'Question ID is required'
    ]);
    exit;
}

if (empty($module)) {
    echo json_encode([
        'success' => false,
        'message' => 'Module is required'
    ]);
    exit;
}

if (empty($answer)) {
    echo json_encode([
        'success' => false,
        'message' => 'Answer is required'
    ]);
    exit;
}

// Check for banned words
$bannedWord = checkBannedWords($answer);
if ($bannedWord) {
    echo json_encode([
        'success' => false,
        'message' => "The word \"$bannedWord\" is not allowed in the answer."
    ]);
    exit;
}

$answer_data = [
    'staff_id' => $_SESSION['user']['username'],
    'answer' => $answer
];

$result = addAnswer($question_id, $answer_data);

if ($result) {
    echo json_encode([
        'success' => true,
        'message' => 'Answer submitted successfully'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to submit answer. Please try again.'
    ]);
}
exit;
