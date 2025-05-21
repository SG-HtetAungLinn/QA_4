<?php
require "./check_auth.php";
require "./common.php";
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit;
}
$question_id = $_POST['question_id'] ?? '';
if (empty($question_id)) {
    echo json_encode([
        'success' => false,
        'message' => 'Question ID is required'
    ]);
    exit;
}
// Get questions using common function
$questions = getQuestions();
// Find the question
$questionIndex = -1;
foreach ($questions as $index => $question) {
    if ($question['id'] === $question_id) {
        $questionIndex = $index;
        break;
    }
}
if ($questionIndex === -1) {
    echo json_encode([
        'success' => false,
        'message' => 'Question not found'
    ]);
    exit;
}
// Remove the question
array_splice($questions, $questionIndex, 1);
// Save back using common function
$data = ['questions' => $questions];
if (writeJson('questions.json', $data)) {
    echo json_encode([
        'success' => true,
        'message' => 'Question deleted successfully'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to delete question'
    ]);
}
