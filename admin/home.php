<!DOCTYPE html>
<html>
<head>
    <title>Home - <?php echo $_settings->info('name') ?></title>
    <!-- Include your CSS and other necessary files here -->
    <style>
        .footer-buttons {
            position: fixed;
            bottom: 10px;
            middle: 10px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .footer-buttons button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: #fff;
        }
        .footer-buttons .btn-primary {
            background-color: #007bff;
        }
        .notification-card {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
   
    </style>
</head>
<body>
    <h1 class="text-light">Welcome to <?php echo $_settings->info('name') ?></h1>
    <hr class="border-light">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-light elevation-1"><i class="fas fa-th-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Category</span>
                    <span class="info-box-number">
                        <?php 
                            $inv = $conn->query("SELECT count(id) as total FROM categories ")->fetch_assoc()['total'];
                            echo number_format($inv);
                        ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="shadow info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users-cog"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Mechanics</span>
                    <span class="info-box-number">
                        <?php 
                            $mechanics = $conn->query("SELECT count(*) as total FROM `mechanics_list` where status = '1' ")->fetch_assoc()['total'];
                            echo number_format($mechanics);
                        ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="shadow info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-th-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Services</span>
                    <span class="info-box-number">
                        <?php 
                            $services = $conn->query("SELECT count(*) as total FROM `service_list` where status = 1 ")->fetch_assoc()['total'];
                            echo number_format($services);
                        ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="shadow info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-file-invoice"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Finished Requests</span>
                    <span class="info-box-number">
                        <?php 
                            $services = $conn->query("SELECT count(*) as total FROM `service_requests` where status = 3 ")->fetch_assoc()['total'];
                            echo number_format($services);
                        ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>

    <?php 
    // Check for service requests with completion date two months from today
    // $two_months_from_now = date('Y-m-d', strtotime('+2 months'));
    // $service_qry = $conn->query("SELECT COUNT(*) as total FROM `service_requests` WHERE DATE(date_created) = '$two_months_from_now'");
    // $service_count = $service_qry->fetch_assoc()['total'];


    // $target_date = '2024-05-30';
    // $service_qry = $conn->query("SELECT COUNT(*) as total FROM `service_requests` WHERE DATE(date_created) = '$target_date'");


    // Calculate the date two months before today
    $two_months_ago = date('Y-m-d', strtotime('-6 months'));

    // Fetch the service requests where the date_created is two months ago
    $service_qry = $conn->query("SELECT COUNT(*) as total FROM `service_requests` WHERE DATE(date_created) = '$two_months_ago'");


    $service_count = $service_qry->fetch_assoc()['total'];

    
    // Check if it's the user's first login of the day
    $current_date = date('Y-m-d');
    $emails_sent_today = isset($_SESSION['emails_sent_today']) ? $_SESSION['emails_sent_today'] : null;
    $show_notification = $service_count > 0;
    // $show_notification = $service_count > 0 && $emails_sent_today != $current_date;
    ?>

    <?php if($show_notification): ?>
    <div class="notification-card">
        <p><?php echo $service_count; ?> clients have next vehicle service reminders to send. Notify them?</p>
        <button id="notify-clients-btn" class="btn btn-primary">OK</button>
        <div class="loader" id="loader"></div>
    </div>
    <?php elseif($emails_sent_today == $current_date): ?>
    <!-- <div class="notification-card">
        <p>Clients were notified today.</p>
        
    </div> -->
    <?php endif; ?>

    <script src="<?php echo base_url ?>plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url ?>dist/js/adminlte.min.js"></script>
    <script src="<?php echo base_url ?>plugins/toastr/toastr.min.js"></script>


    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?php echo base_url ?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?php echo base_url ?>plugins/toastr/toastr.min.js"></script>
    
    <!-- <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script> -->
    

    <script>
    $(document).ready(function(){

         // Get current date
        const currentDate = new Date().toDateString();
        
        // Get stored notification status and date
        const storedNotification = JSON.parse(localStorage.getItem('notificationData'));
        console.log('Stored Notification Data:', storedNotification);

        // Check if notifications were sent today
        if (storedNotification && storedNotification.date === currentDate) {
            if (storedNotification.status === 'true') {
                $('.notification-card').html('<p>Clients were notified today.</p>');
            }
        } else {
            // Reset the local storage for a new day
            localStorage.setItem('notificationData', JSON.stringify({ date: currentDate, status: 'false' }));
        }

        $('#notify-clients-btn').on('click', function(){
            console.log('Notify button clicked. Sending AJAX request to send_notifications.php.');
            // $('#loader').show();
            start_loader();
            $.ajax({
                url: 'send_notifications.php',
                method: 'POST',
                dataType: 'json',
                success: function(response){
                    console.log('AJAX request successful.');
                    console.log('Response:', response);
                    $('.notification-card').html('<p>Clients were notified.</p>');
                    localStorage.setItem('notificationData', JSON.stringify({ date: currentDate, status: 'true' }));
                    // $('#loader').hide();
                    end_loader();
                    alert_toast("Notifications Sent",'success');
                    // location.reload();
                    // Log detailed notification information to the console
                    // if (response.details && response.details.length > 0) {
                    // if (response && response.details && response.details.length > 0) {
                    //     console.log('Notification Details:', response.details);
                    // } else {
                    //     console.log('No clients to notify or details are empty.', response.details);
                    // }

                    console.log('Response Status:', response.status);
                    console.log('Response Message:', response.message);
               
                },
                error: function(xhr, status, error) {
                    console.error('Error occurred while sending notifications:', error);
                    localStorage.setItem('notificationData', JSON.stringify({ date: currentDate, status: 'false' }));
                    // $('#loader').hide();
                    end_loader();
                    alert_toast("An error occurred",'error');
                    // location.reload();
                }    
            });
        });
    });
    </script>


    <footer>
        <div class="footer-buttons">
            <button onclick="window.location.href='" class="btn btn-primary">Feedback</button>
        </div>
    </footer>
</body>
</html>
