<?php
    include('dbhelper.php');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $customerName = $_POST['customer_name'];
        
        // Check if the customer name is not empty
        if (!empty($customerName)) {
            $fields = ['customer_name'];
            $data = [$customerName];
            
            $result = add_records('customers', $fields, $data); // Assuming 'customers' table exists
            
            if ($result) {
                header("Location: sales.php?message=Customer added successfully!");
                exit;
            } else {
                $error = "Error adding customer.";
            }
        } else {
            $error = "Customer name is required.";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Customer</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/w3.css">
</head>
<body>
    <div class="w3-container w3-padding w3-pink">
        <h3>Add Customer</h3>
        <a href="sales.php" class="w3-button w3-blue">Back to Sales</a>
    </div>
    <div class="w3-container w3-padding">
        <?php if (isset($error)): ?>
            <div class="w3-panel w3-red">
                <p><?php echo $error; ?></p>
            </div>
        <?php endif; ?>
        <form action="addcustomer.php" method="post" class="w3-container w3-padding">
            <p>
                <label><b>Customer Name</b></label>
                <input type="text" name="customer_name" class="w3-input w3-border" required>
            </p>
            <p>
                <input type="submit" value="Add Customer" class="w3-button w3-blue">
                <a href="sales.php" class="w3-button w3-red">Cancel</a>
            </p>
        </form>
    </div>
</body>
</html>
