<?php
$to = "manuja@gmail.com";  // Replace with recipient's email address
$subject = "Directed from Form";
$message = "This is a directed message sent using PHP's mail() function.";
// Additional headers
$headers = "From: janath@gmail.com\r\n";  // Replace with your email address
$headers .= "Reply-To: manuja@gmail.com\r\n";  // Replace with your email address
$headers .= "X-Mailer: PHP/" . phpversion();
// Send email
if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully.";
} else {
    echo "Email could not be sent.";
}
?>