<?php
// Include the start.php to handle session management
require 'start.php'; 

// Check if the 'user' session is set and not empty
if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    // Session is active, send a 200 OK response
    http_response_code(200);
    echo json_encode(['message' => 'Session is active']);
} else {
    // Session is not active, send a 401 Unauthorized response
    http_response_code(401);
    echo json_encode(['message' => 'Session expired']);
}
?>