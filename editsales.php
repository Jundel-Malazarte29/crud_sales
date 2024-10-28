<?php
include('dbhelper.php');

// Check if the sales ID is set in the URL
if (isset($_GET['sales_id'])) {
    $sales_id = $_GET['sales_id'];
    $sale = get_sale_by_id($sales_id); // Create this function in dbhelper.php
}

// Handle form submission to update the sale
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sales_date = $_POST['sales_date'];
    $customer_id = $_POST['customer_id'];
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];
    $payment = $_POST['payment'];

    if ($qty > 0) {
        // Update the sales record in the database
        $ok = update_sales($sales_id, $sales_date, $customer_id, $product_id, $qty, $payment); // Create this function in dbhelper.php
        $message = $ok ? "Sales Updated Successfully" : "Error Updating Sales";
        header('Location: sales.php?message=' . $message);
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/w3.css">
    <title>Edit Sales</title>
</head>
<body>
    <div class="w3-container w3-padding">
        <h3>Edit Sales</h3>
        <div class="w3-padding w3-container w3-round-xlarge w3-card-4">
            <form action="" method="post">
                <p>
                    <label><b>SALES DATE</b></label>
                    <input type="text" name="sales_date" value="<?php echo $sale['sales_date']; ?>" class="w3-padding" required>
                </p>
                <p>
                    <label><b>CUSTOMER</b></label>
                    <select name="customer_id" class="w3-select w3-border">
                        <?php
                        $customers = getall_records('customers');
                        foreach ($customers as $customer) {
                            $selected = ($customer['customer_id'] == $sale['customer_id']) ? "selected" : "";
                            echo "<option value='".$customer['customer_id']."' $selected>".strtoupper($customer['customer_name'])."</option>";
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <label><b>PRODUCT NAME</b></label>
                    <select name="product_id" class="w3-select w3-border">
                        <?php
                        $products = getall_records('products');
                        foreach ($products as $p) {
                            $selected = ($p['product_id'] == $sale['product_id']) ? "selected" : "";
                            echo "<option value='".$p['product_id']."' $selected>";
                            echo strtoupper($p['product_name'])."----->".number_format($p['product_price'], 2);
                            echo "</option>";
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <label><b>QTY</b></label>
                    <input type="number" step="0.01" min="0" name="qty" value="<?php echo $sale['qty']; ?>" class="w3-input w3-border" required>
                </p>
                <p>
                    <label><b>PAYMENT</b></label>
                    <select name="payment" class="w3-select w3-border" required>
                        <option value="Cash" <?php echo ($sale['payment'] == 'Cash') ? 'selected' : ''; ?>>Cash</option>
                        <option value="Gcash" <?php echo ($sale['payment'] == 'Gcash') ? 'selected' : ''; ?>>Gcash</option>
                    </select>
                </p>
                <p>
                    <input type="submit" value="SAVE" class="w3-button w3-blue">
                    <input type="reset" value="CANCEL" class="w3-button w3-red">
                </p>
            </form>
        </div>
    </div>
</body>
</html>
