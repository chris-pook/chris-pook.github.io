<?php
    require_once ('../send-email.php');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name      = isset($_POST['name']) ? $_POST['name'] : false;
        $email     = isset($_POST['email']) ? $_POST['email'] : false;
        $phone     = isset($_POST['phone']) ? $_POST['phone'] : false;
        $spamCheck = isset($_POST['other']) ? $_POST['other'] : false;
        $message   = isset($_POST['message']) ? $_POST['message']: false;

        // Required fields check
        if (!$name || !$email || !$message) {
            http_response_code(503);
            exit();
        }

        // Spam bot check
        if ($spamCheck !== base64_encode(date('Y-n-j'))) {
            http_response_code(503);
            exit();
        }

        $body = "Name: {$name}\r\nEmail: {$email}\r\nPhone: {$phone}\r\n\r\n{$message}";
        $subject = "Absolute Commerce :: Request from {$name}";

        $sent = SendEmail::send ($body, $subject);

        echo json_encode(['success' => true]);
    } else {
        http_response_code(405);
        exit();
    }
