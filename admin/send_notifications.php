<?php
// session_start();
require_once('../config.php');

// Fetch the service requests where the completion date is two months from today
// $two_months_from_now = date('Y-m-d', strtotime('+2 months'));
// $service_qry = $conn->query("SELECT * FROM service_requests WHERE DATE(completion_date) = '$two_months_from_now'");


// $target_date = '2024-05-30';
// $service_qry = $conn->query("SELECT * FROM service_requests WHERE DATE(date_created) = '$target_date'");

// Calculate the date two months before today
$two_months_ago = date('Y-m-d', strtotime('-5 months'));

// Fetch the service requests where the date_created is two months ago
$service_qry = $conn->query("SELECT * FROM service_requests WHERE DATE(date_created) = '$two_months_ago'");


$testing_mode = true; // Set to true to bypass the one-time check


$notification_details = [];


// if ($testing_mode || !isset($_SESSION['emails_sent_today']) || $_SESSION['emails_sent_today'] !== date('Y-m-d')) {

// Check if emails were already sent today
// if (!isset($_SESSION['emails_sent_today']) || $_SESSION['emails_sent_today'] !== date('Y-m-d')) {
    // Send reminder emails
    if ($service_qry->num_rows > 0) {
        while ($service = $service_qry->fetch_assoc()) {
            $email = $service['email']; // Assuming 'email' is the column name for client's email
            $subject = "RAS - Your Next Vehicle Service Reminder";
            $message = "Dear Customer,\n\nYour next service which based on previous ID " . $service['id'] . " is scheduled to be completed after 6 months on or about this date" . $service['date_created'] . ". Please don't forget to maintain your vehicle properly to extend its life.\n\nThank you.";
            
            // Additional headers
            $headers = "From: abc@gmail.com\r\n";  // Replace with your email address
            $headers .= "Reply-To: abc@gmail.com\r\n";  // Replace with your email address
            $headers .= "X-Mailer: PHP/" . phpversion();
            
            // Send email
            if(mail($email, $subject, $message, $headers)) {
                $resp['email_status'] = 'Email sent successfully to ' . $email;
            } else {
                $resp['email_status'] = 'Email could not be sent to ' . $email;
            }

            // Log email status
            // error_log($email_status);


            // $notification_details[] = [
            //     'name' => $service['owner_name'], // Assuming 'owner_name' is a column
            //     'email' => $email,
            //     'date_created' => $service['date_created'],
            //     'status' => $email_status
            // ];


        }

        // Update session to indicate emails were sent today
        $_SESSION['emails_sent_today'] = date('Y-m-d');

        $resp['status'] = 'success';
        $resp['message'] = 'Clients were notified';
        // Return JSON response with notification details
        echo json_encode($resp);

        // Display a message or update the UI to reflect that emails were sent
        // echo json_encode(array('status' => 'success', 'message' => 'Emails were sent to clients.'));
    } else {
        // No service requests to notify
        $resp['status'] = 'info';
        $resp['message'] = 'No Clients';
        echo json_encode($resp);
        // echo json_encode(array('status' => 'success', 'message' => 'No clients to notify.'));
    }
// } else {
//     // Emails have already been sent today
//     echo json_encode([
//         'status' => 'info',
//         'message' => 'Already notified',
//         'details' => $notification_details
//     ]);

// //     // echo json_encode(array('status' => 'info', 'message' => 'Clients have already been notified today.'));
// }
?>