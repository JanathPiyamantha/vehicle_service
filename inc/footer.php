<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        .footer-button {
            position: absolute;
            left: 10px; /* Adjust as needed */
        }
        .feedback-button {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        .footer-text {
            position: absolute;
            right: 10px; /* Adjust as needed */
        }
        .footer-container {
            position: relative;
        }
    </style>
</head>
<body>
    <script>
      $(document).ready(function(){
        $('#p_use').click(function(){
          uni_modal("Privacy Policy","policy.php","mid-large")
        })
         window.viewer_modal = function($src = ''){
          start_loader()
          var t = $src.split('.')
          t = t[1]
          if(t =='mp4'){
            var view = $("<video src='"+$src+"' controls autoplay></video>")
          }else{
            var view = $("<img src='"+$src+"' />")
          }
          $('#viewer_modal .modal-content video,#viewer_modal .modal-content img').remove()
          $('#viewer_modal .modal-content').append(view)
          $('#viewer_modal').modal({
                  show:true,
                  backdrop:'static',
                  keyboard:false,
                  focus:true
                })
                end_loader()  
      }
        window.uni_modal = function($title = '' , $url='',$size=""){
            start_loader()
            $.ajax({
                url:$url,
                error:err=>{
                    console.log()
                    alert("An error occurred")
                },
                success:function(resp){
                    if(resp){
                        $('#uni_modal .modal-title').html($title)
                        $('#uni_modal .modal-body').html(resp)
                        if($size != ''){
                            $('#uni_modal .modal-dialog').addClass($size+' modal-dialog-centered')
                        }else{
                            $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md modal-dialog-centered")
                        }
                        $('#uni_modal').modal({
                          show:true,
                          backdrop:'static',
                          keyboard:false,
                          focus:true
                        })
                        end_loader()
                    }
                }
            })
        }
        window._conf = function($msg='',$func='',$params = []){
           $('#confirm_modal #confirm').attr('onclick',$func+"("+$params.join(',')+")")
           $('#confirm_modal .modal-body').html($msg)
           $('#confirm_modal').modal('show')
        }
      })
    </script>

    <!-- Footer-->
    <footer class="py-5 bg-gradient-dark">
      <div class="container footer-container">
        <button onclick="window.location.href='" class="btn btn-primary footer-button">Location</button>
        <button onclick="window.location.href='" class="btn btn-success feedback-button">Feedback Form</button>

        <p class="m-0 text-white footer-text">RAS 2024 (by: <a href="mailto:@gmail.com" class="text-white">Janath</a>)</p>
      </div>
    </footer>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="<?php echo base_url ?>plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="<?php echo base_url ?>plugins/sparklines/sparkline.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url ?>plugins/select2/js/select2.full.min.js"></script>
    <!-- JQVMap -->
    <script src="<?php echo base_url ?>plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?php echo base_url ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo base_url ?>plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?php echo base_url ?>plugins/moment/moment.min.js"></script>
    <script src="<?php echo base_url ?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?php echo base_url ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="<?php echo base_url ?>plugins/summernote/summernote-bs4.min.js"></script>
    <script src="<?php echo base_url ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- overlayScrollbars -->
    <!-- <script src="<?php echo base_url ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> -->
    <!-- AdminLTE App -->
    <script src="<?php echo base_url ?>dist/js/adminlte.js"></script>
    <div class="daterangepicker ltr show-ranges opensright">
      <div class="ranges">
        <ul>
          <li data-range-key="Today">Today</li>
          <li data-range-key="Yesterday">Yesterday</li>
          <li data-range-key="Last 7 Days">Last 7 Days</li>
          <li data-range-key="Last 30 Days">Last 30 Days</li>
          <li data-range-key="This Month">This Month</li>
          <li data-range-key="Last Month">Last Month</li>
          <li data-range-key="Custom Range">Custom Range</li>
        </ul>
      </div>
      <div class="drp-calendar left">
        <div class="calendar-table"></div>
        <div class="calendar-time" style="display: none;"></div>
      </div>
      <div class="drp-calendar right">
        <div class="calendar-table"></div>
        <div class="calendar-time" style="display: none;"></div>
      </div>
      <div class="drp-buttons"><span class="drp-selected"></span><button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button><button class="applyBtn btn btn-sm btn-primary" disabled="disabled" type="button">Apply</button> </div>
    </div>
    <div class="jqvmap-label" style="display: none; left: 1093.83px; top: 394.361px;">Idaho</div>
</body>
</html>
