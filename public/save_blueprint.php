<?php
//save_blueprint.php
session_start();
header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (json_last_error() === JSON_ERROR_NONE && isset($data['blueprint'])) {
    $_SESSION['blueprintData'] = json_encode($data['blueprint']);
    // Return a JSON success message instead of a redirect
    echo json_encode(['success' => true]);
    exit();
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid blueprint data.']);
    exit();
}
?>