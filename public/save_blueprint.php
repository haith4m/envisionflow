<?php
session_start();
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['blueprint'])) {
    $_SESSION['blueprintData'] = json_encode($input['blueprint']); 
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'No blueprint data received']);
}
?>
