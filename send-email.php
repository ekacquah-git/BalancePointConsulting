<?php
// send-email.php
// Basic email handler for a static site hosted on PHP-capable hosting.
// IMPORTANT: For production use, prefer using PHPMailer with SMTP credentials (SendGrid, Mailgun, etc.)

// Recipient email - set to your business address
$recipient = 'info@balancepointconsulting.llc';

// Helper to safely fetch POST fields
function post($key) {
    return isset($_POST[$key]) ? trim($_POST[$key]) : '';
}

$name = strip_tags(post('name'));
$email = filter_var(post('email'), FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars(post('message'));
$redirect = post('redirect') ?: 'index.html';

$errors = [];

if (!$name) {
    $errors[] = 'Name is required.';
}

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Valid email is required.';
}

if (!$message) {
    $errors[] = 'Message is required.';
}

if (!empty($errors)) {
    // Redirect back with error messages (URL-encoded)
    $qs = http_build_query(['success' => 0, 'errors' => $errors]);
    header('Location: ' . $redirect . '?' . $qs);
    exit;
}

$subject = "Website Contact: " . $name;

$body = "You have received a new message from your website contact form:\n\n";
$body .= "Name: " . $name . "\n";
$body .= "Email: " . $email . "\n\n";
$body .= "Message:\n" . $message . "\n";

// Additional headers
$headers = [];
$headers[] = 'From: ' . $name . ' <' . $email . '>';
$headers[] = 'Reply-To: ' . $email;
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-Type: text/plain; charset=UTF-8';

// Try to send the email
$sent = mail($recipient, $subject, $body, implode("\r\n", $headers));

if ($sent) {
    header('Location: ' . $redirect . '?success=1');
    exit;
} else {
    header('Location: ' . $redirect . '?success=0&error=mail_failed');
    exit;
}

?>