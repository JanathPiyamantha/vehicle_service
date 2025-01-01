<?php 
require_once('./../../config.php');

// Initialize variables to prevent PHP notices
$date_created = $owner_name = $contact = $mechanicname = $vehicle_model = $vehicle_name = $delivery_date = $delivery_time = $parts_total = $service_total = $discount = $grand_total = $paid = $payment_status = $order_status = '';

if(isset($_GET['id'])){
    $id = $conn->real_escape_string($_GET['id']);
    $qry = $conn->query("SELECT s.*, c.category FROM `service_requests` s INNER JOIN `categories` c ON s.category_id = c.id WHERE s.id = '{$id}' ");
    if ($qry) {
        $data = $qry->fetch_assoc();
        if ($data) {
            foreach ($data as $k => $v) {
                $$k = $v;
            }

            // Fetch meta data if available
            $meta = $conn->query("SELECT * FROM `request_meta` WHERE request_id = '{$id}'");
            while ($row = $meta->fetch_assoc()) {
                ${$row['meta_field']} = $row['meta_value'];
            }
        } else {
            // Handle if no data found for the given ID
            echo "No data found for ID: {$id}";
            exit;
        }
    } else {
        // Handle query error
        echo "Error fetching data: " . $conn->error;
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <!-- Include jQuery, jQuery UI, and jQuery Timepicker CSS/JS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.js"></script>
    <style>
        #uni_modal .modal-footer {
            display: none;
        }

        span.select2-selection.select2-selection--single,
        span.select2-selection.select2-selection--multiple {
            padding: 0.25rem 0.5rem;
            min-height: calc(1.5em + 0.5rem + 2px);
            height: auto !important;
            max-height: calc(3.5em + 0.5rem + 2px);
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0;
        }
    </style>
</head>
<body>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($order_id) ? "Update" : "Create New" ?> Invoice</h3>
    </div>
    <div class="card-body">
        <form action="service_requests/save_invoice.php" method="POST" id="invoice-form">
            <div class="form-group">
                <label for="date_created" class="control-label">Order Date</label>
                <input name="date_created" id="date_created" type="text" class="form-control rounded-0" value="<?php echo $date_created; ?>" required>
            </div>
            <div class="form-group">
                <label for="owner_name" class="control-label">Owner Name</label>
                <input name="owner_name" id="owner_name" type="text" class="form-control rounded-0" value="<?php echo $owner_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="contact" class="control-label">Owner Contact</label>
                <input name="contact" id="contact" type="text" class="form-control rounded-0" value="<?php echo $contact; ?>" required>
            </div>
            <div class="form-group">
                <label for="mechanicname" class="control-label">Mechanic Name</label>
                <input name="mechanicname" id="mechanicname" type="text" class="form-control rounded-0" value="<?php echo $mechanicname; ?>" required>
            </div>
            <div class="form-group">
                <label for="vehicle_model" class="control-label">Vehicle Type</label>
                <input name="vehicle_model" id="vehicle_model" type="text" class="form-control rounded-0" value="<?php echo $vehicle_model; ?>" required>
            </div>
            <div class="form-group">
                <label for="vehicle_name" class="control-label">Vehicle Name</label>
                <input name="vehicle_name" id="vehicle_name" type="text" class="form-control rounded-0" value="<?php echo $vehicle_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="delivery_date" class="control-label">Delivery Date</label>
                <input name="delivery_date" id="delivery_date" type="text" class="form-control rounded-0" value="<?php echo $delivery_date; ?>" required>
            </div>
            <div class="form-group">
                <label for="delivery_time" class="control-label">Delivery Time (hh:mm:ss)</label>
                <input name="delivery_time" id="delivery_time" type="text" class="form-control rounded-0" value="<?php echo $delivery_time; ?>" required>
            </div>
            <div class="form-group">
                <label for="parts_total" class="control-label">Total Amount for Parts (Rs.)</label>
                <input name="parts_total" id="parts_total" type="number" class="form-control rounded-0" value="<?php echo $parts_total; ?>" required>
            </div>
            <div class="form-group">
                <label for="service_total" class="control-label">Total Amount for Service (Rs.)</label>
                <input name="service_total" id="service_total" type="number" class="form-control rounded-0" value="<?php echo $service_total; ?>" required>
            </div>
            <div class="form-group">
                <label for="discount" class="control-label">Discount (Rs.)</label>
                <input name="discount" id="discount" type="number" class="form-control rounded-0" value="<?php echo $discount; ?>" required>
            </div>
            <div class="form-group">
                <label for="grand_total" class="control-label">Grand Total (Rs.)</label>
                <input name="grand_total" id="grand_total" type="number" class="form-control rounded-0" value="<?php echo $grand_total; ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="paid" class="control-label">Paid (Rs.)</label>
                <input name="paid" id="paid" type="number" class="form-control rounded-0" value="<?php echo $paid; ?>" required>
            </div>
            <div class="form-group">
                <label for="payment_status" class="control-label">Payment Status</label>
                <select name="payment_status" id="payment_status" class="custom-select">
                    <option value="2" <?php echo $payment_status == 2 ? 'selected' : ''; ?>>Paid</option>
                    <option value="1" <?php echo $payment_status == 1 ? 'selected' : ''; ?>>To be paid</option>
                </select>
            </div>
            <div class="form-group">
                <label for="order_status" class="control-label">Order Status</label>
                <select name="order_status" id="order_status" class="custom-select">
                    <option value="2" <?php echo $order_status == 2 ? 'selected' : ''; ?>>Completed</option>
                    <option value="0" <?php echo $order_status == 0 ? 'selected' : ''; ?>>Pending</option>
                </select>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="invoice-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=service_requests">Cancel</a>
    </div>
</div>

<script>
$(function() {
    $("#delivery_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });

    // Function to update the grand total
    function updateGrandTotal() {
        let partsTotal = parseFloat($("#parts_total").val()) || 0;
        let serviceTotal = parseFloat($("#service_total").val()) || 0;
        let discount = parseFloat($("#discount").val()) || 0;
        let grandTotal = (partsTotal + serviceTotal) - discount;
        $("#grand_total").val(grandTotal.toFixed(2));
    }

    // Call updateGrandTotal when relevant fields change
    $("#parts_total, #service_total, #discount").on("input", function() {
        updateGrandTotal();
    });

    // Initialize with existing values
    updateGrandTotal();
});
</script>
</body>
</html>
