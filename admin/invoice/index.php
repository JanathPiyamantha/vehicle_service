<?php if($_settings->chk_flashdata('success')): ?>
<script>
  alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
</script>
<?php endif;?>

<?php 
// Existing code ...

// Query to calculate daily income, count of services, and vehicle types
$dailyIncomeQuery = $conn->query("
  SELECT 
    order_date, 
    SUM(grand_total) as total_income,
    COUNT(*) as total_services,
    GROUP_CONCAT(DISTINCT vehicle_type ORDER BY vehicle_type ASC SEPARATOR ', ') as vehicle_types
  FROM invoice 
  GROUP BY order_date 
  ORDER BY order_date DESC
");
$dailyIncomeData = [];
while($row = $dailyIncomeQuery->fetch_assoc()) {
  $dailyIncomeData[] = $row;
}

// Query to calculate weekly income with month names and most common service type
$weeklyIncomeQuery = $conn->query("
  SELECT 
    DATE_FORMAT(order_date, '%Y-%m') as month,
    WEEK(order_date, 1) as week_number,
    SUM(grand_total) as total_income,
    (
      SELECT vehicle_type 
      FROM invoice 
      WHERE DATE_FORMAT(order_date, '%Y-%u') = DATE_FORMAT(i.order_date, '%Y-%u') 
      GROUP BY vehicle_type 
      ORDER BY COUNT(*) DESC 
      LIMIT 1
    ) as most_common_service
  FROM invoice i
  GROUP BY month, week_number
  ORDER BY month DESC, week_number DESC
");
$weeklyIncomeData = [];
while($row = $weeklyIncomeQuery->fetch_assoc()) {
  $weeklyIncomeData[] = $row;
}

// Query to calculate monthly income, most common service type, and the date with the most services
$monthlyIncomeQuery = $conn->query("
  SELECT 
    DATE_FORMAT(order_date, '%Y-%m') as month,
    SUM(grand_total) as total_income,
    (
      SELECT vehicle_type 
      FROM invoice 
      WHERE DATE_FORMAT(order_date, '%Y-%m') = DATE_FORMAT(i.order_date, '%Y-%m') 
      GROUP BY vehicle_type 
      ORDER BY COUNT(*) DESC 
      LIMIT 1
    ) as most_common_service,
    (
      SELECT order_date 
      FROM invoice 
      WHERE DATE_FORMAT(order_date, '%Y-%m') = DATE_FORMAT(i.order_date, '%Y-%m') 
      GROUP BY order_date 
      ORDER BY COUNT(*) DESC 
      LIMIT 1
    ) as most_services_date,
    (
      SELECT SUM(grand_total) 
      FROM invoice 
      WHERE DATE_FORMAT(order_date, '%Y-%m') = DATE_FORMAT(i.order_date, '%Y-%m') 
      AND order_date = (
        SELECT order_date 
        FROM invoice 
        WHERE DATE_FORMAT(order_date, '%Y-%m') = DATE_FORMAT(i.order_date, '%Y-%m') 
        GROUP BY order_date 
        ORDER BY COUNT(*) DESC 
        LIMIT 1
      )
    ) as most_services_income
  FROM invoice i
  GROUP BY month
  ORDER BY month DESC
");
$monthlyIncomeData = [];
while($row = $monthlyIncomeQuery->fetch_assoc()) {
  $monthlyIncomeData[] = $row;
}
?>

<div class="card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">Daily Income Report</h3>
    <div class="card-tools">
      <button class="btn btn-flat btn-primary" onclick="printReport('dailyReport')"><span class="fas fa-print"></span> Print Daily Report</button>
    </div>
  </div>
  <div class="card-body">
    <div id="dailyReport" class="container-fluid">
      <table class="table table-bordered table-stripped">
        <colgroup>
          <col width="25%">
          <col width="25%">
          <col width="25%">
          <col width="25%">
        </colgroup>
        <thead>
          <tr>
            <th>Date</th>
            <th>Total Income (Rs.)</th>
            <th>Total Services</th>
            <th>Vehicle Types</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($dailyIncomeData as $data): ?>
            <tr>
              <td><?php echo date("Y-m-d", strtotime($data['order_date'])); ?></td>
              <td><?php echo number_format($data['total_income'], 2); ?></td>
              <td><?php echo $data['total_services']; ?></td>
              <td><?php echo $data['vehicle_types']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">Weekly Income Report</h3>
    <div class="card-tools">
      <button class="btn btn-flat btn-primary" onclick="printReport('weeklyReport')"><span class="fas fa-print"></span> Print Weekly Report</button>
    </div>
  </div>
  <div class="card-body">
    <div id="weeklyReport" class="container-fluid">
      <table class="table table-bordered table-stripped">
        <colgroup>
          <col width="30%">
          <col width="20%">
          <col width="20%">
          <col width="30%">
        </colgroup>
        <thead>
          <tr>
            <th>Month</th>
            <th>Week Number</th>
            <th>Total Income (Rs.)</th>
            <th>Most Common Vehicle Type</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($weeklyIncomeData as $data): ?>
            <tr>
              <td><?php echo date("F Y", strtotime($data['month'] . '-01')); ?></td>
              <td><?php echo $data['week_number']; ?></td>
              <td><?php echo number_format($data['total_income'], 2); ?></td>
              <td><?php echo $data['most_common_service']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">Monthly Income Report</h3>
    <div class="card-tools">
      <button class="btn btn-flat btn-primary" onclick="printReport('monthlyReport')"><span class="fas fa-print"></span> Print Monthly Report</button>
    </div>
  </div>
  <div class="card-body">
    <div id="monthlyReport" class="container-fluid">
      <table class="table table-bordered table-stripped">
        <colgroup>
          <col width="20%">
          <col width="20%">
          <col width="20%">
          <col width="20%">
          <col width="20%">
        </colgroup>
        <thead>
          <tr>
            <th>Month</th>
            <th>Total Income (Rs.)</th>
            <th>Most Common Vehicle Type</th>
            <th>Date with Most Services</th>
            <th>Income on Most Services Date (Rs.)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($monthlyIncomeData as $data): ?>
            <tr>
              <td><?php echo date("F Y", strtotime($data['month'] . '-01')); ?></td>
              <td><?php echo number_format($data['total_income'], 2); ?></td>
              <td><?php echo $data['most_common_service']; ?></td>
              <td><?php echo date("Y-m-d", strtotime($data['most_services_date'])); ?></td>
              <td><?php echo number_format($data['most_services_income'], 2); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">List of Invoices</h3>
    <div class="card-tools">
      <a href="?page=invoice/manage_invoice" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Create New</a>
    </div>
  </div>
  <div class="card-body">
    <div class="container-fluid">
      <table class="table table-bordered table-stripped">
        <colgroup>
          <col width="5%">
          <col width="30%">
          <col width="25%">
          <col width="25%">
          <col width="15%">
        </colgroup>
        <thead>
          <tr>
            <th>#</th>
            <th>Invoice Date</th>
            <th>Owner Name</th>
            <th>Contact</th>
            <th>Total Income (Rs.)</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $i = 1;
            $qry = $conn->query("SELECT * from `invoice` order by `owner_name` asc");
            while($row = $qry->fetch_assoc()):
              foreach($row as $k => $v){
                $row[$k] = trim(stripslashes($v));
              }
          ?>
            <tr>
              <td class="text-center"><?php echo $i++; ?></td>
              <td><?php echo date("Y-m-d", strtotime($row['order_date'])); ?></td>
              <td><?php echo ucwords($row['owner_name']); ?></td>
              <td>
                <p class="m-0 lh-1">
                  <?php echo $row['owner_contact']; ?>
                </p>
              </td>
              <td><?php echo number_format($row['grand_total'], 2); ?></td>
              <td class="text-center">
                <?php if($row['payment_status'] == 1): ?>
                  <span class="badge badge-primary">Pending</span>
                <?php elseif($row['payment_status'] == 2): ?>
                  <span class="badge badge-success">Done</span>
                <?php elseif($row['payment_status'] == 3): ?>
                  <span class="badge badge-danger">Cancelled</span>
                <?php else: ?>
                  <span class="badge badge-secondary">N/A</span>
                <?php endif; ?>
              </td>
              <td align="center">
                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                  Action
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu">
                  <a class="dropdown-item view_data" href="?page=invoice/view_invoice&id=<?php echo $row['order_id']; ?>"><span class="fa fa-eye text-primary"></span> View</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="?page=invoice/manage_invoice&id=<?php echo $row['order_id']; ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['order_id']; ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  function printReport(reportId) {
    const printContents = document.getElementById(reportId).innerHTML;
    const signatureSection = `
     <br><br>
      <div style="width: 100%; text-align: right;">
       <p>.....................................</p> 
       <p>Signature</p> </div> `; 
  
       const printableContent = printContents + signatureSection;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = printableContent;

    window.print();

    document.body.innerHTML = originalContents;
  }

  $(document).ready(function(){
    $('.delete_data').click(function(){
      _conf("Are you sure to delete this invoice permanently?", "delete_invoice", [$(this).attr('data-id')]);
    });
    $('.table').dataTable();
  });

  function delete_invoice($id){
    start_loader();
    $.ajax({
      url: _base_url_ + "classes/Master.php?f=delete_invoice",
      method: "POST",
      data: {id: $id},
      dataType: "json",
      error: err => {
        console.log(err);
        alert_toast("An error occurred.", 'error');
        end_loader();
      },
      success: function(resp){
        if (typeof resp === 'object' && resp.status === 'success'){
          location.reload();
        } else {
          alert_toast("An error occurred.", 'error');
          end_loader();
        }
      }
    });
  }
</script>
