<?php
include('dbhelper.php');
// addsales
if (isset($_POST['sales_date']) && isset($_POST['customer_id']) && isset($_POST['product_id']) && isset($_POST['qty']) && isset($_POST['payment'])) {
    $sales_date = $_POST['sales_date']; 
    $customer_id = $_POST['customer_id']; // changed from customer_name to customer_id
    $product_id = $_POST['product_id']; 
    $qty = $_POST['qty']; 
    $payment = $_POST['payment']; // Added payment field

    if ($qty > 0) {
        // Insert the sales record
        $ok = add_records('sales', 
            array('sales_date', 'customer_id', 'product_id', 'qty', 'payment'), // Added 'payment' to the fields
            array($sales_date, $customer_id, $product_id, $qty, $payment) // Added $payment to the values
        );
    }

    $message = ($ok) ? "New Sales Added" : "Error Adding Sales";

    // Redirect back to sales.php with a message
    header('location:sales.php?message=' . urlencode($message));
    exit(); // Always good to exit after a header redirect
}
?>
