<?php
include('dbhelper.php');

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $product = get_product_by_id($product_id);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $product_code = $_POST['product_code'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_unit = $_POST['product_unit'];

        $sql = "UPDATE products SET product_code = :product_code, product_name = :product_name, product_price = :product_price, product_unit = :product_unit WHERE product_id = :product_id";
        $db = dbconnect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':product_code', $product_code);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':product_price', $product_price);
        $stmt->bindParam(':product_unit', $product_unit);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('Product updated successfully');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Failed to update product');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Edit Product</title>
</head>
<body>
    <div class="w3-bar w3-container w3-padding w3-pink">
        <h3>Edit Product</h3>
        <div class="w3-right">
            <a href="index.php" class='w3-button'>HOME</a>
        </div>
    </div>
    <div class="w3-container w3-padding">
        <form method="POST" action="">
            <label>Product Code</label>
            <input type="text" name="product_code" value="<?php echo $product['product_code']; ?>" class="w3-input w3-border" required>
            <label>Product Name</label>
            <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" class="w3-input w3-border" required>
            <label>Product Price</label>
            <input type="number" step="0.01" name="product_price" value="<?php echo $product['product_price']; ?>" class="w3-input w3-border" required>
            <label>Product Unit</label>
            <input type="text" name="product_unit" value="<?php echo $product['product_unit']; ?>" class="w3-input w3-border" required>
            <button type="submit" class="w3-button w3-blue w3-margin-top">Update Product</button>
        </form>
    </div>
</body>
</html>
