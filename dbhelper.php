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

// Get sales
function getsales() {
    $sql = "SELECT sales_id, sales_date, customers.customer_name, products.product_code, products.product_name, 
            products.product_price, products.product_unit, qty, products.product_price * qty as total, sales.payment
            FROM sales 
            INNER JOIN products ON products.product_id = sales.product_id
            INNER JOIN customers ON customers.customer_id = sales.customer_id"; // Add this join
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

// Sales table functions
function get_sale_by_id($sales_id) {
    $sql = "SELECT * FROM sales WHERE sales_id = :sales_id";
    $db = dbconnect();
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':sales_id', $sales_id, PDO::PARAM_INT);
    $stmt->execute();
    $sale = $stmt->fetch(PDO::FETCH_ASSOC);
    $db = null; // Close the connection
    return $sale;
}

function update_sales($sales_id, $sales_date, $customer_id, $product_id, $qty, $payment) {
    $sql = "UPDATE sales SET sales_date = :sales_date, customer_id = :customer_id, product_id = :product_id, qty = :qty, payment = :payment WHERE sales_id = :sales_id";
    $db = dbconnect();
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':sales_date', $sales_date);
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':qty', $qty);
    $stmt->bindParam(':payment', $payment);
    $stmt->bindParam(':sales_id', $sales_id, PDO::PARAM_INT);
    $ok = $stmt->execute();
    $db = null; // Close the connection
    return $ok;
}
