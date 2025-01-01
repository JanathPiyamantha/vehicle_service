<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    echo "<script>console.log('ID: " . htmlspecialchars($_GET['id']) . "');</script>";
    $qry = $conn->query("SELECT * from `invoice` where order_id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
    echo "<script>console.log('Owner Name: " . addslashes($owner_name) . "');</script>";
}
?>
<style>
    body {
        font-family: Arial, sans-serif;
    }
    .invoice-container {
        background-color: #f4f4f4;
        padding: 20px;
        border-radius: 10px;
        max-width: 800px;
        margin: auto;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }
    .invoice-header {
        text-align: center;
        margin-bottom: 20px;
    }
    .invoice-header h1 {
        margin: 0;
    }
    .invoice-header p {
        margin: 0;
    }
    .invoice-body {
        padding: 10px;
        background-color: #fff;
        border-radius: 10px;
    }
    .invoice-details {
        width: 100%;
        margin-bottom: 20px;
    }
    .invoice-details th, .invoice-details td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }
    .invoice-details th {
        background-color: #f8f8f8;
    }
    .invoice-footer {
        text-align: center;
        margin-top: 20px;
    }
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn-primary {
        background-color: #007bff;
        color: #fff;
    }
    .btn-default {
        background-color: #6c757d;
        color: #fff;
    }
    .btn-primary:hover, .btn-default:hover {
        opacity: 0.8;
    }
    .thank-you {
        text-align: center;
        margin-top: 20px;
        font-size: 16px;
        font-weight: bold;
    }
    .watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 50px;
        color: rgba(0, 0, 0, 0.1);
        text-align: center;
        pointer-events: none;
        z-index: 0;
    }
    .watermark span {
        display: inline-block;
        transform: rotate(30deg);
    }
    .grand-total {
        margin-top: 20px;
        padding: 10px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .grand-total span {
        font-size: 24px;
        font-weight: bold;
    }
    @media print {
        .invoice-container {
            box-shadow: none;
            margin: 0;
            padding: 0;
            border-radius: 0;
        }
        .btn {
            display: none;
        }
        .grand-total span {
            font-size: 24px;
            font-weight: bold;
        }
    }
</style>

<div class="invoice-container">
    <div class="watermark">
        <span>AUTHORIZED SERVICE CENTER</span>
    </div>
    <div class="invoice-header">
        <h1>Ruwan Auto Service</h1>
        <p>Gorakadeniya, Nelligahamula</p>
        <h2><?php echo isset($order_id) ? "Invoice #" . $order_id : "New Invoice" ?></h2>
    </div>
    <div class="invoice-body">
        <table class="invoice-details">
            <tr>
                <th>Order Date</th>
                <td><?php echo isset($order_date) ? $order_date : ''; ?></td>
            </tr>
            <tr>
                <th>Owner Name</th>
                <td><?php echo isset($owner_name) ? $owner_name : ''; ?></td>
            </tr>
            <tr>
                <th>Owner Contact</th>
                <td><?php echo isset($owner_contact) ? $owner_contact : ''; ?></td>
            </tr>
            <tr>
                <th>Mechanic Name</th>
                <td><?php echo isset($mechanicname) ? $mechanicname : ''; ?></td>
            </tr>
            <tr>
                <th>Vehicle Type</th>
                <td><?php echo isset($vehicle_type) ? $vehicle_type : ''; ?></td>
            </tr>
            <tr>
                <th>Vehicle Name</th>
                <td><?php echo isset($vehicle_name) ? $vehicle_name : ''; ?></td>
            </tr>
            <tr>
                <th>Delivery Date</th>
                <td><?php echo isset($delivery_date) ? $delivery_date : ''; ?></td>
            </tr>
            <tr>
                <th>Delivery Time</th>
                <td><?php echo isset($delivery_time) ? $delivery_time : ''; ?></td>
            </tr>
            <tr>
                <th>Total Amount for Parts (Rs.)</th>
                <td><?php echo isset($parts_total) ? $parts_total : ''; ?></td>
            </tr>
            <tr>
                <th>Total Amount for Service (Rs.)</th>
                <td><?php echo isset($service_total) ? $service_total : ''; ?></td>
            </tr>
            <tr>
                <th>Discount (Rs.)</th>
                <td><?php echo isset($discount) ? $discount : ''; ?></td>
            </tr>
            <tr>
                <th>Paid (Rs.)</th>
                <td><?php echo isset($paid) ? $paid : ''; ?></td>
            </tr>
            <tr>
                <th>Payment Status</th>
                <td><?php echo isset($payment_status) ? ($payment_status == 1 ? 'To be Paid' : 'Paid') : ''; ?></td>
            </tr>
            <tr>
                <th>Order Status</th>
                <td><?php echo isset($order_status) ? ($order_status == 2 ? 'Done' : ($order_status == 1 ? 'Active' : 'Pending')) : ''; ?></td>
            </tr>
        </table>
        <div class="grand-total">
            <span>Grand Total (Rs.): <?php echo isset($grand_total) ? $grand_total : ''; ?></span>
        </div>
    </div>
    <div class="thank-you">
        Thank you for choosing us! Come again.
    </div>
    <!-- <div class="invoice-footer">
        <button class="btn btn-default" onclick="window.location.href='?page=invoice'">Close</button>
        <button class="btn btn-primary" onclick="printInvoice()">Print</button>
    </div> -->
</div>
<div class="invoice-footer">
        <button class="btn btn-default" onclick="window.location.href='?page=invoice'">Close</button>
        <button class="btn btn-primary" onclick="printInvoice()">Print</button>
    </div>
<script>
    function printInvoice() {
        var printContents = document.querySelector('.invoice-container').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>
