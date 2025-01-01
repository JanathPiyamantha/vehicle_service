<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_category(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($_POST['description'])){
			if(!empty($data)) $data .=",";
				$data .= " `description`='".addslashes(htmlentities($description))."' ";
		}
		$check = $this->conn->query("SELECT * FROM `categories` where `category` = '{$category}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Category already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `categories` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `categories` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Category successfully saved.");
			else
				$this->settings->set_flashdata('success',"Category successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_category(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `categories` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Category successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_service(){
		extract($_POST);
		$data = "";
		$_POST['description'] = addslashes(htmlentities($description));
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `service_list` where `service` = '{$service}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Service already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `service_list` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `service_list` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Service successfully saved.");
			else
				$this->settings->set_flashdata('success',"Service successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_service(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `service_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Service successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_mechanic(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `mechanics_list` where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Mechanic already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `mechanics_list` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `mechanics_list` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Mechanic successfully saved.");
			else
				$this->settings->set_flashdata('success',"Mechanic successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_mechanic(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `mechanics_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Mechanic successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_product(){ 
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('product_id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		// echo $data;

		// error_log("Data string: {$data}");
		
		$check = $this->conn->query("SELECT * FROM `product` where `product_name` = '{$product_name}' ".(!empty($product_id) ? " and product_id != {$product_id} " : "")." ")->num_rows;

		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Part already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($product_id)){
			$sql = "INSERT INTO `product` set {$data}";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `product` set {$data} where product_id = '{$product_id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($product_id))
				$this->settings->set_flashdata('success',"New part successfully saved.");
			else
				$this->settings->set_flashdata('success',"Part successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_product(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `product` where product_id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Product successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_invoice(){ 
		// echo "function called";
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('order_id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		// echo $data;

		// error_log("Data string: {$data}");
		
		$check = $this->conn->query("SELECT * FROM `invoice` where `owner_name` = '{$owner_name}' ".(!empty($order_id) ? " and order_id != {$order_id} " : "")." ")->num_rows;

		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Invoice already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($order_id)){
			$sql = "INSERT INTO `invoice` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `invoice` set {$data} where order_id = '{$order_id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($order_id))
				$this->settings->set_flashdata('success',"New invoice successfully saved.");
			else
				$this->settings->set_flashdata('success',"Invoice successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_invoice(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `invoice` where order_id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Invoice successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		header('Content-Type: application/json');
		return json_encode($resp);

	}
	function save_request(){
		extract($_POST);
		$data = "";
		$current_status = null;
		error_log("save_request called with id: " . $id);

		if (!empty($id)) {
			$qry = $this->conn->query("SELECT status FROM service_requests WHERE id = '{$id}'");
			if ($qry && $qry->num_rows > 0) {
				$current_status = $qry->fetch_assoc()['status'];
			}
		}

		foreach($_POST as $k=> $v){
			if(in_array($k,array('owner_name','email','category_id','service_type','mechanic_id','status'))){
				if(!empty($data)){ $data .= ", "; }

				$data .= " {$k} = '{$v}'";

			}
		}
		if(empty($id)){
			$sql = "INSERT INTO service_requests set {$data} ";
		}else{
			$sql = "UPDATE service_requests set {$data} where id ='{$id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$rid = empty($id) ? $this->conn->insert_id : $id ;
			$data = "";
			foreach($_POST as $k=> $v){
				if(!in_array($k,array('id','owner_name','email','category_id','service_type','mechanic_id','status'))){
					if(!empty($data)){ $data .= ", "; }
					if(is_array($_POST[$k]))
					$v = implode(",",$_POST[$k]);
					$v = $this->conn->real_escape_string($v);
					$data .= "('{$rid}','{$k}','{$v}')";
				}
			}
			$sql = "INSERT INTO request_meta (request_id,meta_field,meta_value) VALUES {$data} ";
			$this->conn->query("DELETE FROM request_meta where request_id = '{$rid}' ");
			$save = $this->conn->query($sql);
			if($save){
				if (isset($status) && $status != $current_status) {

					$status_texts = [
						0 => 'Pending',
						1 => 'Confirmed',
						2 => 'On-Progress',
						3 => 'Done',
						4 => 'Cancelled'
					];
					
					$status_text = isset($status_texts[$status]) ? $status_texts[$status] : 'Unknown';
					// Email content
					$to = "{$email}";  // Replace with the recipient's email address
					$subject = "RAS - Service Request Status Changed";
					$message = "The status of your service request has been changed to: ". $status_text;
					$message .= ".   If you have any requirement or need any clarification please call on below number.\n\n";
					$message .= "Contact NO: 0789054672\n";
					$message .= "Thank you!\n";
					$message .= "Ruwan Auto Service";
		
					// Additional headers
					$headers = "From: janath@gmail.com\r\n";  // Replace with your email address
					$headers .= "Reply-To: {$email}\r\n";  // Replace with your email address
					$headers .= "X-Mailer: PHP/" . phpversion();
		
					// Send email
					if(mail($to, $subject, $message, $headers)) {
						$resp['email_status'] = 'Email sent successfully.';
					} else {
						$resp['email_status'] = 'Email could not be sent.';
					}
				}

				$resp['status'] = 'success';
				$resp['id'] = $rid;
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = $this->conn->error;
				$resp['sql'] = $sql;
			}

		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
			$resp['sql'] = $sql;
		}

		return json_encode($resp);
	}
	// function save_request(){
	// 	extract($_POST);
	// 	$data = "";
	// 	foreach($_POST as $k=> $v){
	// 		if(in_array($k,array('owner_name','email','category_id','service_type','mechanic_id','status'))){
	// 			if(!empty($data)){ $data .= ", "; }

	// 			$data .= " `{$k}` = '{$v}'";

	// 		}
	// 	}
	// 	if(empty($id)){
	// 		$sql = "INSERT INTO `service_requests` set {$data} ";
	// 	}else{
	// 		$sql = "UPDATE `service_requests` set {$data} where id ='{$id}' ";
	// 	}
	// 	$save = $this->conn->query($sql);
	// 	if($save){
	// 		$rid = empty($id) ? $this->conn->insert_id : $id ;
	// 		$data = "";
	// 		foreach($_POST as $k=> $v){
	// 			if(!in_array($k,array('id','owner_name','email','category_id','service_type','mechanic_id','status'))){
	// 				if(!empty($data)){ $data .= ", "; }
	// 				if(is_array($_POST[$k]))
	// 				$v = implode(",",$_POST[$k]);
	// 				$v = $this->conn->real_escape_string($v);
	// 				$data .= "('{$rid}','{$k}','{$v}')";
	// 			}
	// 		}
	// 		$sql = "INSERT INTO `request_meta` (`request_id`,`meta_field`,`meta_value`) VALUES {$data} ";
	// 		$this->conn->query("DELETE FROM `request_meta` where `request_id` = '{$rid}' ");
	// 		$save = $this->conn->query($sql);
	// 		if($save){
	// 			$resp['status'] = 'success';
	// 			$resp['id'] = $rid;
	// 		}else{
	// 			$resp['status'] = 'failed';
	// 			$resp['msg'] = $this->conn->error;
	// 			$resp['sql'] = $sql;
	// 		}

	// 	}else{
	// 		$resp['status'] = 'failed';
	// 		$resp['msg'] = $this->conn->error;
	// 		$resp['sql'] = $sql;
	// 	}

	// 	return json_encode($resp);
	// }
	function delete_request(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `service_requests` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Request successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function send_email() {
		
		global $conn;
		extract($_POST);
		// error_log("send_email called with id: " . $id);
		$id = isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : null);

		if (!$id) {
			return json_encode(['status' => 'failed', 'msg' => 'Service request ID is required']);
		}
		// $id = $_POST['id'];
		
		// Fetch email and owner_name from the database
		$qry = $this->conn->query("SELECT owner_name, email FROM service_requests WHERE id = '{$id}'");
		if ($qry) {
			if ($qry->num_rows > 0) {
			$row = $qry->fetch_assoc();
			$owner_name = $row['owner_name'];
			$email = $row['email'];
			
			// Email content
			$to = $email;
			$subject = "RAS - Reminder about the next service";
			$message = "Dear " . ucwords($owner_name) . ",\n\n";
			$message .= "It's time for your vehicle's next service. Please send a service request when you are ready.\n\n";
			$message .= "Thank you!\n";
			$message .= "Ruwan Auto Service";
			// Additional headers
			$headers = "From: janath@gmail.com\r\n";  // Replace with your email address
			$headers .= "Reply-To: janath@gmail.com\r\n";  // Replace with your email address
			$headers .= "X-Mailer: PHP/" . phpversion();
			
			// Send email
			if(mail($to, $subject, $message, $headers)) {
				$resp['status'] = 'success';
			} else {
				$resp['status'] = 'failed';
			}
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = 'Service request not found';
		}
	} else {
        error_log("Query failed: " . $conn->error);
        $resp['status'] = 'failed';
        $resp['msg'] = 'Service request not found';
    }
		
		echo json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_category':
		echo $Master->save_category();
	break;
	case 'delete_category':
		echo $Master->delete_category();
	break;
	case 'save_service':
		echo $Master->save_service();
	break;
	case 'delete_service':
		echo $Master->delete_service();
	break;
	case 'save_mechanic':
		echo $Master->save_mechanic();
	break;
	case 'delete_mechanic':
		echo $Master->delete_mechanic();
	break;
	case 'save_request':
		echo $Master->save_request();
	break;
	case 'delete_request':
		echo $Master->delete_request();
	break;
	case 'save_product':
		echo $Master->save_product();
	break;
	case 'delete_product':
		echo $Master->delete_product();
	break;
	case 'save_invoice':
		echo $Master->save_invoice();
	break;
	case 'delete_invoice':
		echo $Master->delete_invoice();
	break;
	case 'send_email':
		echo $Master->send_email();
	break;
	default:
		// echo $sysset->index();
		break;
}