<?php
require './common.php';
header('Content-Type: application/json');
$result = getModules();
echo json_encode([
    "success" => true,
    "result" => $result
]);
exit;
