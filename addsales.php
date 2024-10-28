<?php
	include('dbhelper.php');
	//addsales
	if(isset($_POST['sales_date']) && isset($_POST['customer_name']) && isset($_POST['product_id']) && isset($_POST['qty'])){
		$sales_date = $_POST['sales_date']; 
		$customer_name = $_POST['customer_name']; 
		$product_id = $_POST['product_id']; 
		$qty = $_POST['qty']; 
		if($qty>0){
			$ok = add_records('sales',array('sales_date','customer_name','product_id','qty'),array($sales_date,$customer_name,$product_id,$qty));
		//using ternary operator
		}
		$message = ($ok)?"New Sales Added":"Error Adding Sales";
		
		header('location:sales.php?message='.$message);
	}
?>