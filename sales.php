<?php 
include('dbhelper.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge,safari">
    <link rel="stylesheet" href="css/bootstrap.min.css"> 
    <link rel="stylesheet" href="css/w3.css">
    <title>Sari-Sari Store v1.0</title>
</head>
<body>
    <div class="w3-bar w3-container w3-padding w3-pink">
        <h3>Sales</h3>
        <div class="w3-right">
            <a href="index.php" class='w3-button'>HOME</a>
            <a href="addcustomer.php" class='w3-button'>ADD CUSTOMER</a>
            <a href="addproduct.php" class='w3-button'>ADD PRODUCT</a>
            <a href="sales.php" class='w3-button'>SALES</a>
        </div>
    </div>
    <div class="w3-container w3-padding">
        <?php
        if(isset($_GET['message'])){
            $message = $_GET['message'];
            echo "<div class='w3-panel w3-amber w3-padding'>";
            echo "<h4>".$message."</h4>";
            echo "</div>";
        }
        ?>
        <div class="w3-row-padding">
            <div class="w3-third">
                <div class="w3-padding w3-container w3-round-xlarge w3-card-4">
                    <form action="addsales.php" method="post">
                        <p>
                            <label><b>SALES DATE</b></label>
                            <input type="text" name="sales_date" value="<?php echo date('Y/m/d'); ?>" class="w3-padding" required>
                        </p>
                        <p>
                            <label><b>CUSTOMER</b></label>
                            <select name="customer_id" class="w3-select w3-border" required>
                                <?php
                                $customers = getall_records('customers');
                                foreach ($customers as $customer) {
                                    echo "<option value='".$customer['customer_id']."'>".strtoupper($customer['customer_name'])."</option>";
                                }
                                ?>
                            </select>
                        </p>
                        <p>
                            <label><b>PRODUCT NAME</b></label>
                            <select name="product_id" class="w3-select w3-border" required>
                                <?php
                                $products = getall_records('products');
                                foreach ($products as $p) {
                                    echo "<option value='".$p['product_id']."'>";
                                    echo strtoupper($p['product_name'])."----->".number_format($p['product_price'], 2);
                                    echo "</option>";
                                }
                                ?>
                            </select>
                        </p>
                        <p>
                            <label><b>QTY</b></label>
                            <input type="number" step="0.01" min="0" name="qty" class="w3-input w3-border" required>
                        </p>
                        <p>
                            <label><b>PAYMENT</b></label>
                            <select name="payment" class="w3-select w3-border" required>
                                <option value="Cash">Cash</option>
                                <option value="Gcash">Gcash</option>
                            </select>
                        </p>
                        <p>
                            <input type="submit" value="SAVE" class="w3-button w3-blue">
                            <input type="reset" value="CANCEL" class="w3-button w3-red">
                        </p>
                    </form>
                </div>
            </div>
            <div class="w3-twothird">
                <?php
                $subtotal = 0.0;
                $sales = getsales(); // Ensure this function is properly retrieving sales data
                echo "<table class='w3-table-all'>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>DATE</th>";
                echo "<th class='w3-hide-small w3-hide-medium'>CUSTOMER</th>";
                echo "<th class='w3-hide-small w3-hide-medium'>PRODUCT NAME</th>";
                echo "<th class='w3-hide-large w3-hide-medium'>PRODUCT CODE</th>";
                echo "<th class='w3-hide-small w3-hide-medium'>UNIT</th>";
                echo "<th>PRICE</th>";
                echo "<th>QTY</th>";
                echo "<th>PAYMENT</th>"; // Added header for payment
                echo "<th>TOTAL</th>";
                echo "<th>ACTION</th>";
                echo "</tr>";
                foreach ($sales as $sale) {
                    echo "<tr>";
                    echo "<td>".$sale['sales_id']."</td>";
                    echo "<td>".$sale['sales_date']."</td>";
                    echo "<td class='w3-hide-small w3-hide-medium'>".$sale['customer_name']."</td>";
                    echo "<td class='w3-hide-small w3-hide-medium'>".$sale['product_name']."</td>";
                    echo "<td class='w3-hide-large w3-hide-medium'>".$sale['product_code']."</td>";
                    echo "<td class='w3-hide-small w3-hide-medium'>".$sale['product_unit']."</td>";
                    echo "<td>".number_format($sale['product_price'], 2)."</td>";
                    echo "<td>".$sale['qty']."</td>";
                    echo "<td class='w3-center'>".$sale['payment']."</td>"; // Display payment method
                    echo "<td class='w3-right'>".number_format($sale['total'], 2)."</td>";
                    echo "<td class='w3-center'>"; // Center alignment for action
                    echo "<a href='editsales.php?sales_id=".$sale['sales_id']."' class='w3-button w3-blue'>EDIT</a>";
                    echo "<a href='deletesales.php?sales_id=".$sale['sales_id']."' class='w3-button w3-red'>DELETE</a>";
                    echo "</td>";
                    echo "</tr>";
                    $subtotal += $sale['total'];
                }
                echo "</table>";
                echo "<div class='w3-container w3-right'>";
                echo "<b> SUBTOTAL --> : ";
                echo number_format($subtotal, 2);
                echo "</b>";
                echo "</div>";
                ?>
            </div>
        </div>
    </div>
</body>
</html>
