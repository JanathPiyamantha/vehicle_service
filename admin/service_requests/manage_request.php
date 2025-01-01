<?php 
require_once('./../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT s.*,c.category FROM `service_requests` s inner join `categories` c on s.category_id = c.id where s.id = '{$_GET['id']}' ");
    foreach($qry->fetch_array() as $k => $v){
        $$k = $v;
    }
    $meta = $conn->query("SELECT * FROM `request_meta` where request_id = '{$id}'");
    while($row = $meta->fetch_assoc()){
        ${$row['meta_field']} = $row['meta_value'];
    }
}
?>
<style>
    #uni_modal .modal-footer{
        display:none
    }
    span.select2-selection.select2-selection--single,span.select2-selection.select2-selection--multiple {
        padding: 0.25rem 0.5rem;
        min-height: calc(1.5em + 0.5rem + 2px);
        height:auto !important;
        max-height:calc(3.5em + 0.5rem + 2px);
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0;
    }
</style>
<div class="container-fluid">
    <form action="email" id="request_form" method="post">
        <input type="hidden" name="id" value="<?php echo isset($id) ?  $id : "" ?>">
        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category_id" class="control-label">Vehicle Type</label>
                        <select name="category_id" id="category_id" class="form-select form-select-sm select2 rounded-0" required>
                            <option disabled selected></option>
                            <?php 
                            $category = $conn->query("SELECT * FROM `categories` where status = 1 order by category asc");
                            while($row = $category->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['id'] ?>" <?php echo isset($category_id) && $row['id'] == $category_id ? "selected" : "" ?>><?php echo  $row['category'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="owner_name" class="control-label">Owner Fullname</label>
                        <input type="text" name="owner_name" id="owner_name" class="form-control form-control-sm rounded-0" value="<?php echo isset($owner_name) ? $owner_name : "" ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="owner_nic" class="control-label">Owner NIC Number</label>
                        <input type="text" name="nic" id="nic" class="form-control form-control-sm rounded-0" value="<?php echo isset($nic) ? $nic : "" ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="contact" class="control-label">Owner Contact Number</label>
                        <input type="text" name="contact" id="contact" class="form-control form-control-sm rounded-0" value="<?php echo isset($contact) ? $contact : "" ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Owner Email</label>
                        <input type="text" name="email" id="email" class="form-control form-control-sm rounded-0" value="<?php echo isset($email) ? $email : "" ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <textarea rows="3" name="address" id="address" class="form-control form-control-sm rounded-0" style="resize:none" required><?php echo isset($address) ? $address : "" ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="vehicle_name" class="control-label">Vehicle Brand & Name</label>
                        <input type="text" name="vehicle_name" id="vehicle_name" class="form-control form-control-sm rounded-0" value="<?php echo isset($vehicle_name) ? $vehicle_name : "" ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="vehicle_registration_number" class="control-label">Vehicle Registration Number</label>
                        <input type="text" name="vehicle_registration_number" id="vehicle_registration_number" class="form-control form-control-sm rounded-0" value="<?php echo isset($vehicle_registration_number) ? $vehicle_registration_number : "" ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="vehicle_model" class="control-label">Vehicle Model</label>
                        <select name="vehicle_model" id="vehicle_model" class="form-select form-select-sm rounded-0" required>
                            <option disabled selected></option>
                            <option value="SUV" <?php echo isset($vehicle_model) && $vehicle_model == 'SUV' ? "selected" : "" ?>>SUV</option>
                            <option value="Passenger Car" <?php echo isset($vehicle_model) && $vehicle_model == 'Passenger Car' ? "selected" : "" ?>>Passenger Car</option>
                            <option value="MotorBike" <?php echo isset($vehicle_model) && $vehicle_model == 'MotorBike' ? "selected" : "" ?>>MotorBike</option>
                            <option value="Three Wheeler" <?php echo isset($vehicle_model) && $vehicle_model == 'Three Wheeler' ? "selected" : "" ?>>Three Wheeler</option>
                            <option value="ATV" <?php echo isset($vehicle_model) && $vehicle_model == 'ATV' ? "selected" : "" ?>>ATV</option>
                            <option value="Pickup Truck" <?php echo isset($vehicle_model) && $vehicle_model == 'Pickup Truck' ? "selected" : "" ?>>Pickup Truck</option>
                            <option value="Van" <?php echo isset($vehicle_model) && $vehicle_model == 'Van' ? "selected" : "" ?>>Van</option>
                            <option value="Mini Lorry" <?php echo isset($vehicle_model) && $vehicle_model == 'Mini Lorry' ? "selected" : "" ?>>Mini Lorry</option>
                            <option value="Truck" <?php echo isset($vehicle_model) && $vehicle_model == 'Truck' ? "selected" : "" ?>>Truck</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kilometers_traveled" class="control-label">Kilometers Traveled So Far</label>
                        <input type="number" name="kilometers_traveled" id="kilometers_traveled" class="form-control form-control-sm rounded-0" value="<?php echo isset($kilometers_traveled) ? $kilometers_traveled : "" ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="service_id" class="control-label">Services</label>
                        <select name="service_id[]" id="service_id" class="form-select form-select-sm select2 rounded-0" multiple required>
                            <option disabled></option>
                            <?php 
                            $service = $conn->query("SELECT * FROM `service_list` where status = 1 order by `service` asc");
                            while($row = $service->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['id'] ?>" <?php echo isset($service_id) && in_array($row['id'],explode(",",$service_id))? "selected" : '' ?>><?php echo  $row['service'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="service_type" class="control-label">Request Type</label>
                        <select name="service_type" id="service_type" class="form-select form-select-sm select2 rounded-0" required>
                            <option <?php echo isset($service_type) && $service_type == 'Drop Off' ? "selected" : '' ?>>Drop Off</option>
                            <option <?php echo isset($service_type) && $service_type == 'Pick Up' ? "selected" : '' ?>>Pick Up</option>
                        </select>
                    </div>
                    <div class="form-group" id="pickup_address_group" <?php echo isset($service_type) && $service_type == 'Drop Off' ? 'style="display:none"' : '' ?>>
                        <label for="pickup_address" class="control-label">Pick up Address</label>
                        <textarea rows="3" name="pickup_address" id="pickup_address" class="form-control form-control-sm rounded-0" style="resize:none" <?php echo isset($service_type) && $service_type == 'Pick Up' ? 'required' : '' ?>><?php echo isset($pickup_address) ? $pickup_address : "" ?></textarea>
                    </div>
                </div>
            </div>
            <hr class="border-light">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group " id="mechanic-holder">
                        <label for="mechanic_id" class="control-label">Assigned To:</label>
                        <select name="mechanic_id" id="mechanic_id" class="form-select form-select-sm rounded-0" required>
                            <option disabled <?php echo !isset($mechanic_id) || (isset($mechanic_id) && empty($mechanic_id)) ? "selected" : "" ?>></option>
                            <?php 
                            $mechanic = $conn->query("SELECT * FROM `mechanics_list` where status = 1 order by `name` asc");
                            while($row = $mechanic->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['id'] ?>" <?php echo isset($mechanic_id) && in_array($row['id'],explode(",",$mechanic_id))? "selected" : '' ?>><?php echo  $row['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <select name="status" id="status" class="custom-select custom-select-sm rounded-0" required>
                            <option value="0" <?php echo isset($status) && $status == 0 ? "selected" : '' ?>>Pending</option>
                            <option value="1" <?php echo isset($status) && $status == 1 ? "selected" : '' ?>>Confirmed</option>
                            <option value="2" <?php echo isset($status) && $status == 2 ? "selected" : '' ?>>On-Progress</option>
                            <option value="3" <?php echo isset($status) && $status == 3 ? "selected" : '' ?>>Done</option>
                            <option value="4" <?php echo isset($status) && $status == 4 ? "selected" : '' ?>>Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 d-flex justify-content-end mx-2">
            <div class="col-auto">
                <button class="btn btn-primary btn-sm rounded-0" id="save_request_btn">Save Request</button>
                <button class="btn btn-light btn-sm rounded-0" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(function(){
        $('.select2').select2({
            placeholder:"Please Select Here",
            dropdownParent: $('#uni_modal')
        });
        $('#mechanic_id').select2({
            placeholder:"Please Select Here",
            dropdownParent: $('#mechanic-holder')
        });
        $('#service_type').change(function(){
            var type = $(this).val().toLowerCase();
            if(type == 'pick up'){
                $('#pickup_address_group').show();
                $('#pickup_address').attr('required', true);
            }else{
                $('#pickup_address_group').hide();
                $('#pickup_address').attr('required', false);
            }
        });
        $('#request_form').submit(function(e){
            e.preventDefault();
            let contact = $('#contact').val();
            let nic = $('#nic').val();
            let vehicle_registration_number = $('#vehicle_registration_number').val();
            let kilometers_traveled = $('#kilometers_traveled').val();

            if(contact.length != 10 || !/^\d+$/.test(contact)){
                alert_toast("Owner contact number must be exactly 10 digits.", 'warning');
                return false;
            }
            if(nic.length < 10 || nic.length > 11){
                alert_toast("Owner NIC number must be between 10 and 11 characters.", 'warning');
                return false;
            }
            if(!/^[A-Za-z0-9-]{1,8}$/.test(vehicle_registration_number)){
                alert_toast("Vehicle registration number must be a maximum of 8 characters (digits, English letters, or dash).", 'warning');
                return false;
            }
            if(!/^\d+$/.test(kilometers_traveled)){
                alert_toast("Kilometers traveled must be digits only.", 'warning');
                return false;
            }
            
            start_loader();
            $.ajax({
                url: _base_url_+'classes/Master.php?f=save_request',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                error: function(err){
                    console.log(err);
                    alert_toast("An error occurred",'error');
                    end_loader();
                },
                success: function(resp){
                    end_loader();
                    if(resp.status == 'success'){
                        alert_toast("Data successfully saved",'success');
                        setTimeout(() => {
                            uni_modal("Service Request Details","service_requests/view_request.php?id="+resp.id,'large');
                            $('#uni_modal').on('hidden.bs.modal',function(){
                                location.reload();
                            });
                        }, 200);
                    }else{
                        alert_toast("An error occurred",'error');
                    }
                }
            });
        });
    });
</script>
