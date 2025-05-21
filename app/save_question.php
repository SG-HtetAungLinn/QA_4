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

$title = $_POST['title'] ?? '';
$question = $_POST['question'] ?? '';
$module = $_POST['module'] ?? '';

// Validate input
if (empty($title)) {
    echo json_encode([
        'success' => false,
        'message' => 'Title is required'
    ]);
    exit;
}

if (empty($question)) {
    echo json_encode([
        'success' => false,
        'message' => 'Question is required'
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

// Add question
$question_data = [
    'title' => $title,
    'content' => $question,
    'module_code' => $module,
    'student_id' => $_SESSION['user']['username']
];

if (addQuestion($question_data)) {
    echo json_encode([
        'success' => true,
        'message' => 'Question submitted successfully'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to submit question. Please try again.'
    ]);
}
exit;
