<?php

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Include PHPMailer autoloader
require __DIR__ . '/vendor/autoload.php';

// Old function to send email using PHPMailer
function sendEmail($recipient, $subject, $message) {
    // Instantiate PHPMailer
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@example.com'; // Replace with your email address
        $mail->Password = 'your_password'; // Replace with your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587; // Port might vary for different SMTP providers

        // Email content
        $mail->setFrom('your_email@example.com', 'Your Name'); // Replace with your email and name
        $mail->addAddress($recipient);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send email
        $mail->send();
        return true; // Email sent successfully
    } catch (Exception $e) {
        return false; // Failed to send email
    }
}

// Create Slim app
$app = AppFactory::create();

// Old function route
$app->get('/old-send-email', function (Request $request, Response $response) {
    $recipient = 'recipient@example.com'; // Replace with recipient email
    $subject = 'Test Subject';
    $message = 'Test message from old function';

    // Call old function to send email
    $result = sendEmail($recipient, $subject, $message);

    if ($result) {
        $response->getBody()->write('Email sent successfully using old function');
    } else {
        $response->getBody()->write('Failed to send email using old function');
    }

    return $response;
});

// New endpoint to send email using Slim
$app->post('/send-email', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $recipient = $data['recipient'];
    $subject = $data['subject'];
    $message = $data['message'];

    // Call old function to send email
    $result = sendEmail($recipient, $subject, $message);

    if ($result) {
        return $response->withJson(['message' => 'Email sent successfully']);
    } else {
        return $response->withStatus(500)->withJson(['error' => 'Failed to send email']);
    }
});

// Run Slim app
$app->run();

?>