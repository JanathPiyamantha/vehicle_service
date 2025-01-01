<style>
    table td, table th {
        padding: 3px !important;
    }
</style>
<?php 
$date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date("Y-m-d", strtotime(date("Y-m-d")." -7 days"));
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] : date("Y-m-d");
?>
<div class="card card-primary card-outline">
    <div class="card-header">
        <h5 class="card-title">Vehicle Service Requests Report</h5>
    </div>
    <div class="card-body">
        <form id="filter-form">
            <div class="row align-items-end">
                <div class="form-group col-md-3">
                    <label for="date_start">Date Start</label>
                    <input type="date" class="form-control form-control-sm" name="date_start" value="<?php echo date("Y-m-d", strtotime($date_start)) ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="date_end">Date End</label>
                    <input type="date" class="form-control form-control-sm" name="date_end" value="<?php echo date("Y-m-d", strtotime($date_end)) ?>">
                </div>
                <div class="form-group col-md-1">
                    <button class="btn btn-flat btn-block btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
                </div>
                <div class="form-group col-md-1">
                    <button class="btn btn-flat btn-block btn-success btn-sm" type="button" id="printBTN"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
        </form>
        <hr>
        <div id="printable">
            <div>
                <h4 class="text-center m-0"><?php echo $_settings->info('name') ?></h4>
                <h3 class="text-center m-0"><b>Service Requests Report</b></h3>
                <p class="text-center m-0">Date Between <?php echo $date_start ?> and <?php echo $date_end ?></p>
                <hr>
            </div>
            <table class="table table-bordered">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Time</th>
                        <th>Owner Name</th>
                        <th>Vehicle Name</th>
                        <th>Vehicle Reg. No.</th>
                        <th>Assigned To</th>
                        <th>Service</th>
                        <th>Status</th>
                        <th>Kilometers Traveled</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    $mechanic = $conn->query("SELECT * FROM mechanics_list");
                    $result = $mechanic->fetch_all(MYSQLI_ASSOC);
                    $mech_arr = array_column($result, 'name', 'id');
                    $where = "where date(date_created) between '{$date_start}' and '{$date_end}'";
                    $qry = $conn->query("SELECT * from service_requests {$where} order by unix_timestamp(date_created) desc");
                    while ($row = $qry->fetch_assoc()):
                        $meta = $conn->query("SELECT * FROM request_meta where request_id = '{$row['id']}'");
                        while ($mrow = $meta->fetch_assoc()) {
                            $row[$mrow['meta_field']] = $mrow['meta_value'];
                        }
                        $services = $conn->query("SELECT * FROM service_list where id in ({$row['service_id']}) ");
                        while ($srow = $services->fetch_assoc()):
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++ ?></td>
                        <td><?php echo $row['date_created'] ?></td>
                        <td><?php echo $row['owner_name'] ?></td>
                        <td><?php echo $row['vehicle_name'] ?></td>
                        <td><?php echo $row['vehicle_registration_number'] ?></td>
                        <td><?php echo !empty($row['mechanic_id']) && isset($mech_arr[$row['mechanic_id']]) ? $mech_arr[$row['mechanic_id']] : "N/A" ?></td>
                        <td><?php echo $srow['service'] ?></td>
                        <td class='text-center'>
                            <?php if ($row['status'] == 1): ?>
                                <span class="badge badge-primary">Confirmed</span>
                            <?php elseif ($row['status'] == 2): ?>
                                <span class="badge badge-warning">On-progress</span>
                            <?php elseif ($row['status'] == 3): ?>
                                <span class="badge badge-success">Done</span>
                            <?php elseif ($row['status'] == 4): ?>
                                <span class="badge badge-danger">Cancelled</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['kilometers_traveled'] ?></td>
                        <td>
                            <button class="btn btn-info print-single-btn btn-sm">Print</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php endwhile; ?>
                    <?php if ($qry->num_rows <= 0): ?>
                    <tr>
                        <td class="text-center" colspan="9">No Data...</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<noscript>
    <style>
        .m-0 {
            margin: 0;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .table {
            border-collapse: collapse;
            width: 100%;
        }
        .table tr, .table td, .table th {
            border: 1px solid gray;
        }
    </style>
</noscript>
<script>
    $(function(){
        $('#filter-form').submit(function(e){
            e.preventDefault()
            location.href = "./?page=report&date_start="+$('[name="date_start"]').val()+"&date_end="+$('[name="date_end"]').val()
        })

        $('#printBTN').click(function(){
            var rep = $('#printable').clone();
            var ns = $('noscript').clone().html();
            start_loader()
            rep.prepend(ns)
            var nw = window.document.open('', '_blank', 'width=900,height=600')
                nw.document.write(rep.html())
                nw.document.close()
                nw.print()
                setTimeout(function(){
                    nw.close()
                    end_loader()
                }, 500)
        })

        $('.print-single-btn').click(function(){
            var tr = $(this).closest('tr').clone();
            var ns = $('noscript').clone().html();
            start_loader()
            tr.prepend(ns)
            var nw = window.document.open('', '_blank', 'width=900,height=600')
                nw.document.write(`
                    <html>
                    <head>
                        <title>Print Service Detail</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; padding: 20px; }
                            h4, h3 { text-align: center; margin: 0; }
                            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                            table th { background-color: #4CAF50; color: white; padding: 8px; }
                            table td { padding: 8px; }
                            table tr:nth-child(even) { background-color: #f2f2f2; }
                            table tr:hover { background-color: #ddd; }
                            .badge { padding: 5px 10px; border-radius: 5px; }
                            .badge-primary { background-color: #007bff; color: white; }
                            .badge-success { background-color: #28a745; color: white; }
                            .badge-warning { background-color: #ffc107; color: black; }
                            .badge-danger { background-color: #dc3545; color: white; }
                            .badge-secondary { background-color: #6c757d; color: white; }
                        </style>
                    </head>
                    <body>
                        <h4><?php echo $_settings->info('name') ?></h4>
                        <h3>Service Request Detail</h3>
                        <hr>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date Time</th>
                                    <th>Owner Name</th>
                                    <th>Vehicle Name</th>
                                    <th>Vehicle Reg. No.</th>
                                    <th>Assigned To</th>
                                    <th>Service</th>
                                    <th>Status</th>
                                    <th>Kilometers Traveled</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${tr.html()}
                            </tbody>
                        </table>
                    </body>
                    </html>
                `)
                nw.document.close()
                nw.print()
                setTimeout(function(){
                    nw.close()
                    end_loader()
                }, 500)
        })
    })
</script>
