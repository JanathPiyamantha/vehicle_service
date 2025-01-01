<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Service Requests</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="5%">
					<col width="25%">
					<col width="25%">
					<col width="25%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Owner Name</th>
						<th>Service</th>
						<th>Status</th>
						<th>Action</th>
						<th>Invoice</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT * from service_requests order by unix_timestamp(date_created) desc");
						while($row = $qry->fetch_assoc()):
							$sids = $conn->query("SELECT meta_value FROM request_meta where request_id = '{$row['id']}' and meta_field = 'service_id'")->fetch_assoc()['meta_value'];
							$services  = $conn->query("SELECT * FROM service_list where id in ({$sids}) ");
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo ucwords($row['owner_name']) ?></td>
							<td>
								<p class="m-0 truncate-3">
								<?php 
									$s = 0;
									while($srow = $services->fetch_assoc()){
										$s++;
										if($s != 1) echo ", ";
										echo $srow['service'];
									}
								?>	
								</p>
							</td>
							<td class="text-center">
								<?php if($row['status'] == 1): ?>
									<span class="badge badge-primary">Confirmed</span>
								<?php elseif($row['status'] == 2): ?>
									<span class="badge badge-warning">On-progress</span>
								<?php elseif($row['status'] == 3): ?>
									<span class="badge badge-success">Done</span>
								<?php elseif($row['status'] == 4): ?>
									<span class="badge badge-danger">Cancelled</span>
								<?php else: ?>
									<span class="badge badge-secondary">Pending</span>
								<?php endif; ?>
							</td>
							<td align="center">
								<div class="dropdown">
									<button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Action
									</button>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-primary"></span> View</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item send_email" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-envelope text-info"></span> Email</a>
										<!-- <a class="dropdown-item" href="https://mail.google.com/mail/u/0/#inbox?compose=new" target="_blank"><span class="fa fa-envelope text-info"></span> Email</a> -->
									</div>
								</div>
							</td>
							<td>
								<div>
									<a class="create_invoice" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" class="btn btn-flat btn-primary"> Create</a>
								</div>


							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		// $('.send_email').click(function(){
		// 	var id = $(this).attr('data-id');
		// 	start_loader();
		// 	$.ajax({
		// 		url: base_url + "classes/Master.php?f=send_email",
		// 		method: "POST",
		// 		data: {id: id},
		// 		dataType: "json",
		// 		error: err => {
		// 			console.log(err)
		// 			alert_toast("An error occurred.", 'error');
		// 			end_loader();
		// 		},
		// 		success: function(resp){
		// 			if (typeof resp == 'object' && resp.status == 'success') {
		// 				alert_toast("Email sent successfully.", 'success');
		// 			} else {
		// 				alert_toast("An error occurred.", 'error');
		// 			}
		// 			end_loader();
		// 		}
		// 	})
		// });
		// $('.send_email').click(function(){
        //     var id = $(this).attr('data-id');
        //     send_email(id);
        // });
		$('.send_email').click(function(){
			_conf("Are you sure to send an email?","send_email",[$(this).attr('data-id')])
		})
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this service request permanently?","delete_service_request",[$(this).attr('data-id')])
		})
		$('.create_invoice').click(function(){
			uni_modal("Creating Invoice","service_requests/invoice.php?id="+$(this).attr('data-id'),'large')
		})
		$('.view_data').click(function(){
			uni_modal("Service Request Details","service_requests/view_request.php?id="+$(this).attr('data-id'),'large')
		})
		$('#create_new').click(function(){
			uni_modal("Service Request Details","service_requests/manage_request.php",'large')
		})
		$('.edit_data').click(function(){
			uni_modal("Service Request Details","service_requests/manage_request.php?id="+$(this).attr('data-id'),'large')
		})
		$('.table').dataTable();
	})
	function delete_service_request($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_request",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
	function send_email($id){
			// var id = $(this).attr('data-id');
			// start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=send_email",
				method: "POST",
				data: {id: $id},
				dataType: "json",
				error: err => {
					console.log(err)
					alert_toast("An error occurred.", 'error');
					// end_loader();
				},
				success: function(resp){
					if (typeof resp == 'object' && resp.status == 'success') {
						alert_toast("Email sent successfully.", 'success');
						// end_loader();
					} else {
						alert_toast("An error occurred.", 'error');
						// end_loader();
					}
					
				}
			})
		};
</script>
