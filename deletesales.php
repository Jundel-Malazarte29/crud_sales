<?php
	include('dbhelper.php');
	///delete record
	if(isset($_GET['sales_id'])){
		$sales_id = $_GET['sales_id'];
		$ok = delete_records('sales','sales_id',$sales_id);
		$message = ($ok==1)?"Sales Transaction Deleted":"Error Deleting Sales";
		header('location:sales.php?message='.$message);
	}
?>