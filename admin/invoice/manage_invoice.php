<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    echo "<script>console.log('ID: " . htmlspecialchars($_GET['id']) . "');</script>";
    $qry = $conn->query("SELECT * from `invoice` where order_id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=stripslashes($v);
        }
    }
    echo "<script>console.log('Product Name: " . addslashes($owner_name) . "');</script>";
}
?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($order_id) ? "Update ": "Create New " ?> Invoice</h3>
    </div>
    <div class="card-body">
        <form action="" id="invoice-form">
            <input type="hidden" name ="order_id" value="<?php echo isset($order_id) ? $order_id : '' ?>">
            <div class="form-group">
                <label for="order_date" class="control-label">Order Date</label>
                <input name="order_date" id="order_date" type="text" class="form-control rounded-0" value="<?php echo isset($order_date) ? $order_date : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="owner_name" class="control-label">Owner Name</label>
                <input name="owner_name" id="owner_name" type="text" class="form-control rounded-0" value="<?php echo isset($owner_name) ? $owner_name : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="owner_contact" class="control-label">Owner Contact</label>
                <input name="owner_contact" id="owner_contact" type="text" class="form-control rounded-0" value="<?php echo isset($owner_contact) ? $owner_contact : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="mechanicname" class="control-label">Mechanic Name</label>
                <input name="mechanicname" id="mechanicname" type="text" class="form-control rounded-0" value="<?php echo isset($mechanicname) ? $mechanicname : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="vehicle_type" class="control-label">Vehicle Type</label>
                <input name="vehicle_type" id="vehicle_type" type="text" class="form-control rounded-0" value="<?php echo isset($vehicle_type) ? $vehicle_type : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="vehicle_name" class="control-label">Vehicle Name</label>
                <input name="vehicle_name" id="vehicle_name" type="text" class="form-control rounded-0" value="<?php echo isset($vehicle_name) ? $vehicle_name : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="delivery_date" class="control-label">Delivery Date</label>
                <input name="delivery_date" id="delivery_date" type="text" class="form-control rounded-0" value="<?php echo isset($delivery_date) ? $delivery_date : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="delivery_time" class="control-label">Delivery Time (hh:mm:ss)</label>
                <input name="delivery_time" id="delivery_time" type="text" class="form-control rounded-0" value="<?php echo isset($delivery_time) ? $delivery_time : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="parts_total" class="control-label">Total Amount for Parts (Rs.)</label>
                <input name="parts_total" id="parts_total" type="text" class="form-control rounded-0" pattern="\d+" title="Please enter digits only" value="<?php echo isset($parts_total) ? $parts_total : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="service_total" class="control-label">Total Amount for Service (Rs.)</label>
                <input name="service_total" id="service_total" type="text" class="form-control rounded-0" pattern="\d+" title="Please enter digits only" value="<?php echo isset($service_total) ? $service_total : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="discount" class="control-label">Discount (Rs.)</label>
                <input name="discount" id="discount" type="text" class="form-control rounded-0" pattern="\d+" title="Please enter digits only" value="<?php echo isset($discount) ? $discount : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="grand_total" class="control-label">Grand Total (Rs.)</label>
                <input name="grand_total" id="grand_total" type="text" class="form-control rounded-0" pattern="\d+" title="Please enter digits only" value="<?php echo isset($grand_total) ? $grand_total : ''; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="paid" class="control-label">Paid (Rs.)</label>
                <input name="paid" id="paid" type="text" class="form-control rounded-0" pattern="\d+" title="Please enter digits only" value="<?php echo isset($paid) ? $paid : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="payment_status" class="control-label">Payment Status</label>
                <select name="payment_status" id="payment_status" class="custom-select selevt">
                    <option value="2" <?php echo isset($payment_status) && $payment_status == 2 ? 'selected' : '' ?>>Paid</option>
                    <option value="1" <?php echo isset($payment_status) && $payment_status == 1 ? 'selected' : '' ?>>To be paid</option>
                </select>
            </div>
            <div class="form-group">
                <label for="order_status" class="control-label">Order Status</label>
                <select name="order_status" id="order_status" class="custom-select selevt">
                    <option value="2" <?php echo isset($order_status) && $order_status == 2 ? 'selected' : '' ?>>Completed</option>
                    <option value="0" <?php echo isset($order_status) && $order_status == 0 ? 'selected' : '' ?>>Pending</option>
                </select>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="invoice-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=invoice">Cancel</a>
    </div>
</div>
<script>
     $(function() {
        $("#delivery_date").datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true
        });
    });

    $(document).ready(function(){
        // Function to calculate the grand total
        function calculateGrandTotal() {
            var partsTotal = parseFloat($('#parts_total').val()) || 0;
            var serviceTotal = parseFloat($('#service_total').val()) || 0;
            var discount = parseFloat($('#discount').val()) || 0;
            var grandTotal = partsTotal + serviceTotal - discount;
            $('#grand_total').val(grandTotal.toFixed(2));
        }

        // Trigger calculation on input change
        $('#parts_total, #service_total, #discount').on('input', function() {
            calculateGrandTotal();
        });

        $('#invoice-form').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();

            var formData = new FormData(_this[0]);
            var valid = true;

            formData.forEach((value, key) => {
                if (key === 'parts_total' || key === 'service_total' || key === 'discount' || key === 'grand_total' || key === 'paid') {
                    if (!/^\d+(\.\d{1,2})?$/.test(value)) {
                        valid = false;
                        alert_toast(key.replace('_', ' ') + " should contain digits only.", 'error');
                        return false;
                    }
                }
            });

            if (!valid) {
                end_loader();
                return false;
            }

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_invoice",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occured", 'error');
                    end_loader();
                },
                success: resp => {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.href = "./?page=invoice/view_invoice&id=" + resp.id;
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>')
                            .addClass("alert alert-danger err-msg")
                            .text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                        end_loader();
                    } else {
                        alert_toast("An error occured", 'error');
                        end_loader();
                        console.log(resp);
                    }
                }
            });
        });
    });
</script>
