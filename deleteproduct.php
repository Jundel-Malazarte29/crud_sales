<?php
include('dbhelper.php');

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "DELETE FROM products WHERE product_id = $product_id";

    if (postprocess($sql)) {
        echo "<script>alert('Product deleted successfully');</script>";
    } else {
        echo "<script>alert('Failed to delete product');</script>";
    }
}
echo "<script>window.location.href = 'index.php';</script>";
?>
