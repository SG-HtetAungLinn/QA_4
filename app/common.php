<?php
$dataPath = __DIR__ . '/../data/';
function readJson($filename)
{
    global $dataPath;
    $filePath = $dataPath . $filename;
    if (file_exists($filePath)) {
        $jsonContent = file_get_contents($filePath);
        return json_decode($jsonContent, true);
    }
    return null;
}
function writeJson($filename, $data)
{
    global $dataPath;
    $filePath = $dataPath . $filename;
    $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
    return file_put_contents($filePath, $jsonContent);
}

function getModules()
{
    $data = readJson('modules.json');
    return $data['modules'] ?? [];
}

function getModuleByCode($code)
{
    $modules = getModules();
    foreach ($modules as $module) {
        if ($module['code'] === $code) {
            return $module;
        }
    }
    return null;
}

function getQuestions($moduleCode = null)
{
    $data = readJson('questions.json');
    $questions = $data['questions'] ?? [];
    if ($moduleCode) {
        $questions = array_filter($questions, function ($q) use ($moduleCode) {
            return $q['module_code'] === $moduleCode;
        });
    }
    return $questions;
}

function addQuestion($question)
{
    $data = readJson('questions.json');
    $questions = $data['questions'] ?? [];
    $question['id'] = uniqid();
    $question['created_at'] = date('Y-m-d H:i:s');
    $question['answers'] = [];
    $question['votes'] = [];
    $questions[] = $question;
    $data['questions'] = $questions;
    return writeJson('questions.json', $data);
}

function addAnswer($questionId, $answer)
{
    $data = readJson('questions.json');
    $questions = $data['questions'] ?? [];
    foreach ($questions as &$question) {
        if ($question['id'] === $questionId) {
            $answer['id'] = uniqid();
            $answer['created_at'] = date('Y-m-d H:i:s');
            $question['answers'][] = $answer;
            break;
        }
    }
    $data['questions'] = $questions;
    return writeJson('questions.json', $data);
}

function addVote($questionId, $userId)
{
    $data = readJson('questions.json');
    $questions = $data['questions'] ?? [];
    foreach ($questions as &$question) {
        if ($question['id'] === $questionId) {
            $voteIndex = array_search($userId, $question['votes']);
            if ($voteIndex === false) {
                $question['votes'][] = $userId;
            } else {
                array_splice($question['votes'], $voteIndex, 1);
            }
            break;
        }
    }
    $data['questions'] = $questions;
    return writeJson('questions.json', $data);
}

function getQuestionById($questionId)
{
    $questions = getQuestions();
    foreach ($questions as $question) {
        if ($question['id'] === $questionId) {
            return $question;
        }
    }
    return null;
}

function checkBannedWords($text)
{
    $bannedWords = [
        'XXXTEST',
        'YYYTEST',
        'ZZZTEST'
    ];
    foreach ($bannedWords as $word) {
        if (stripos($text, $word) !== false) {
            return $word;
        }
    }
    return false;
}
