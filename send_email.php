<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader
require '/home/sam/sandbox/email_sender/PHPMailer/src/PHPMailer.php';
require '/home/sam/sandbox/email_sender/PHPMailer/src/Exception.php';
require '/home/sam/sandbox/email_sender/PHPMailer/src/SMTP.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $recipient = $_POST['recipient'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Instantiate PHPMailer
    $mail = new PHPMailer(true);

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
        echo 'Email has been sent successfully!';
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
