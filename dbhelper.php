<?php
/// database helper

function dbconnect() {
    try {
        // Updated connection string to include MySQL, host, and database name
        $conn = new PDO("mysql:host=localhost;dbname=sales_db", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode
        return $conn;
    } catch (PDOException $e) { 
        echo "Connection failed: " . $e->getMessage();
    }
}

function getprocess($sql) {
    $db = dbconnect();
    $rows = $db->query($sql);
    $db = null; // Close the PDO connection
    return $rows;
}

function postprocess($sql) {
    $db = dbconnect();
    $stmt = $db->prepare($sql);
    $ok = $stmt->execute(); // Return 1 if SUCCESS else null
    $db = null; // Close the PDO connection
    return $ok;
}

function getall_records($table) {
    $sql = "SELECT * FROM `$table`";
    return getprocess($sql);
}

function add_records($table, $fields, $data) {
    $ok = null;
    if (count($fields) == count($data)) {
        $keys = implode("`,`", $fields);
        $values = implode("','", $data);
        $sql = "INSERT INTO `$table`(`$keys`) VALUES('$values')";
        return postprocess($sql);
    }
}

function getsales() {
    $sql = "SELECT s.sales_id, s.sales_date, c.customer_name, p.product_code, p.product_name, p.product_price, p.product_unit, s.qty, (p.product_price * s.qty) AS total
            FROM sales s
            INNER JOIN products p ON p.product_id = s.product_id
            INNER JOIN customers c ON c.customer_id = s.customer_id"; // Assuming you have a customer_id in the sales table
    return getprocess($sql);
}

function delete_records($table, $field, $data) {
    $sql = "DELETE FROM `$table` WHERE `$field` = '$data'";
    return postprocess($sql);
}

// Get the product by id - to edit product
function get_product_by_id($product_id) {
    $sql = "SELECT * FROM products WHERE product_id = :product_id";
    $db = dbconnect();
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    $db = null; // close the connection
    return $product;
}

// Get all customers for dropdown selection
function getall_customers() {
    return getall_records('customers');
}
