<?php
require_once('./../../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming $conn is your database connection object

    // Sanitize and validate the input data
    $date_created = $conn->real_escape_string($_POST['date_created']);
    $owner_name = $conn->real_escape_string($_POST['owner_name']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $mechanicname = $conn->real_escape_string($_POST['mechanicname']);
    $vehicle_model = $conn->real_escape_string($_POST['vehicle_model']);
    $vehicle_name = $conn->real_escape_string($_POST['vehicle_name']);
    $delivery_date = $conn->real_escape_string($_POST['delivery_date']);
    $delivery_time = $conn->real_escape_string($_POST['delivery_time']);
    $parts_total = $conn->real_escape_string($_POST['parts_total']);
    $service_total = $conn->real_escape_string($_POST['service_total']);
    $discount = $conn->real_escape_string($_POST['discount']);
    $grand_total = $conn->real_escape_string($_POST['grand_total']);
    $paid = $conn->real_escape_string($_POST['paid']);
    $payment_status = $conn->real_escape_string($_POST['payment_status']);
    $order_status = $conn->real_escape_string($_POST['order_status']);

    // Prepare the SQL query using prepared statement (recommended for security)
    $stmt = $conn->prepare("INSERT INTO invoice (order_date, owner_name, owner_contact, mechanicname, vehicle_type, vehicle_name, delivery_date, delivery_time, parts_total, service_total, discount, grand_total, paid, payment_status, order_status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssssss", $date_created, $owner_name, $contact, $mechanicname, $vehicle_model, $vehicle_name, $delivery_date, $delivery_time, $parts_total, $service_total, $discount, $grand_total, $paid, $payment_status, $order_status);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to a success page with a success message
        header('Location: /vehicle_service/admin/?page=service_requests');
        exit;
    } else {
        // Redirect to the form page with an error message
        header('Location: /vehicle_service/admin/?page=service_requests');
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
