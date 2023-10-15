<?php
    function sendError($text) {
        echo json_encode([
            'success' => false, 
            'error' => $text
        ]);
        exit;
    }
?>