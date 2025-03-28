<?php
// Include database connection
include 'config.php';

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // SQL query to insert data
    $sql = "INSERT INTO users (username, email, phone, subject, message) 
            VALUES ('$username', '$email', '$phone', '$subject', '$message')";
    
    // Execute query and check if successful
    if (mysqli_query($conn, $sql)) {
        // Database insertion successful, now send email
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';    
            $mail->SMTPAuth   = true;
            $mail->Username   = '124ashishbhandari@gmail.com';  
            $mail->Password   = 'ahto nafr wdgm fcbs';            
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
           
            $mail->setFrom('124ashishbhandari@gmail.com', $username);
            
          
            $mail->addAddress($email, $username);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;  
            
            // Email body
            $mail->Body = "
                <p>Dear $username,</p>
                <p>Thank you for contacting us. This is a confirmation that we received your message:</p>
                <hr>
                <p><strong>Subject:</strong> $subject</p>
                <p><strong>Message:</strong> $message</p>
                <hr>
                <p>We will get back to you soon at this email address: $email</p>
                <p>Your phone number on file: $phone</p>
                <br>
                <p>Best regards,<br>Support Team</p>
            ";
       
            $mail->AltBody = "Dear $username,\n\nThank you for contacting us. This is a confirmation that we received your message:\n\nSubject: $subject\nMessage: $message\n\nWe will get back to you soon at this email address: $email\nYour phone number on file: $phone\n\nBest regards,\nSupport Team";

            $mail->send();
            $response = ['success' => true, 'message' => 'Form submitted successfully and confirmation email sent.'];
        } catch (Exception $e) {
        
            $response = ['success' => true, 'message' => 'Form submitted successfully but email failed: ' . $mail->ErrorInfo];
        }
    } else {
        // Database insertion failed
        $response = ['success' => false, 'message' => 'Error: ' . mysqli_error($conn)];
    }
    
    // Close database connection
    mysqli_close($conn);
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    // If not POST request
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Method not allowed'
    ]);
}
?> 