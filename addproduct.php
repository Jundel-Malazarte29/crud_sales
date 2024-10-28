<?php
include('dbhelper.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $product_code = $_POST['product_code'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_unit = $_POST['product_unit'];

    // Check if all fields are filled
    if (!empty($product_code) && !empty($product_name) && !empty($product_price) && !empty($product_unit)) {
        // Add product to the database
        $fields = ['product_code', 'product_name', 'product_price', 'product_unit'];
        $data = [$product_code, $product_name, $product_price, $product_unit];
        
        $result = add_records('products', $fields, $data);
        
        if ($result) {
            echo "<script>alert('Product added successfully');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Failed to add product');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge,safari">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Add New Product</title>
</head>
<body>
    <div class="w3-bar w3-container w3-padding w3-pink">
        <h3>Add New Product</h3>
        <div class="w3-right">
            <a href="index.php" class='w3-button'>HOME</a>
            <a href="sales.php" class='w3-button'>SALES</a>
        </div>
    </div>
    <div class="w3-container w3-padding">
        <form method="POST" action="addproduct.php">
            <label>Product Code</label>
            <input type="text" name="product_code" class="w3-input w3-border" required>
            
            <label>Product Name</label>
            <input type="text" name="product_name" class="w3-input w3-border" required>
            
            <label>Product Price</label>
            <input type="number" step="0.01" name="product_price" class="w3-input w3-border" required>
            
            <label>Product Unit</label>
            <input type="text" name="product_unit" class="w3-input w3-border" required>
            
            <button type="submit" class="w3-button w3-green w3-margin-top">Add Product</button>
        </form>
    </div>
</body>
</html>
