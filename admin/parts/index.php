<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Products</h3>
        <div class="card-tools">
            <a href="?page=parts/manage_part" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table id="productTable" class="table table-bordered table-striped">
                <colgroup>
                    <col width="5%">
                    <col width="20%">
                    <col width="20%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="5%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Product Image</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT * FROM product ORDER BY product_name ASC");
                        while($row = $qry->fetch_assoc()):
                            foreach($row as $k => $v){
                                $row[$k] = trim(stripslashes($v));
                            }
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo ucwords($row['product_name']); ?></td>
                            <td class="text-center">
                                <img src="<?php echo $row['product_image']; ?>" alt="Product Image" class="img-thumbnail" style="max-width: 100px;">
                            </td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td>Rs. <?php echo $row['rate']; ?></td>
                            <td><?php echo date("Y-m-d H:i", strtotime($row['created_at'])); ?></td>
                            <td><?php echo date("Y-m-d H:i", strtotime($row['updated_at'])); ?></td>
                            <td class="text-center">
                                <?php 
                                    $status = "";
                                    switch ($row['status']) {
                                        case 1:
                                            $status = '<span class="badge badge-primary">Available</span>';
                                            break;
                                        case 2:
                                            $status = '<span class="badge badge-warning">On-progress</span>';
                                            break;
                                        case 3:
                                            $status = '<span class="badge badge-success">Done</span>';
                                            break;
                                        case 4:
                                            $status = '<span class="badge badge-danger">Cancelled</span>';
                                            break;
                                        default:
                                            $status = '<span class="badge badge-secondary">Unavailable</span>';
                                            break;
                                    }
                                    echo $status;
                                ?>
                            </td>
                            <td align="center">
                                 <div class="btn-group">
                                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        Action
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item" href="?page=parts/manage_part&id=<?php echo $row['product_id']; ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['product_id']; ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <a href="https://eautoparts.lk/" target="_blank" class="btn btn-primary"><span class="fa fa-link"></span> E - Autoparts 01</a>
                </div>
                <div class="col-auto">
                    <a href="https://www.dpmco.com/en/products/genuine-spare-parts.html" target="_blank" class="btn btn-primary"><span class="fa fa-link"></span> David Pieris Motor Company</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">

<script>
    $(document).ready(function() {
        $('#productTable').DataTable({
            "lengthMenu": [ [5, 10, 15, 20, -1], [5, 10, 15, 20, "All"] ],
            "columnDefs": [
                { "orderable": false, "targets": [2, 8] }
            ]
        });
    });

    $(document).ready(function(){
    $('.delete_data').click(function(){
      _conf("Are you sure to delete this part permanently?", "delete_product", [$(this).attr('data-id')]);
    });
    $('.table').dataTable();
  });

  function delete_product($product_id){
    start_loader();
    $.ajax({
      url: _base_url_ + "classes/Master.php?f=delete_product",
      method: "POST",
      data: {id: $product_id},
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

    function printTable() {
        html2canvas(document.getElementById('productTable')).then(function(canvas) {
            var imgData = canvas.toDataURL('image/png');
            var pdf = new jsPDF();
            pdf.addImage(imgData, 'PNG', 10, 10);
            pdf.save('products.pdf');
        });
    }
</script>
