-- Create the database
CREATE DATABASE IF NOT EXISTS sales_db;
USE sales_db;

-- Create products table
CREATE TABLE IF NOT EXISTS products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_code VARCHAR(50) NOT NULL,
    product_name VARCHAR(100) NOT NULL,
    product_price DECIMAL(10, 2) NOT NULL,
    product_unit VARCHAR(20) NOT NULL
);

-- Create customers table
CREATE TABLE IF NOT EXISTS customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL UNIQUE
);

-- Create sales table
CREATE TABLE IF NOT EXISTS sales (
    sales_id INT AUTO_INCREMENT PRIMARY KEY,
    sales_date DATE NOT NULL,
    customer_id INT NOT NULL,
    product_id INT NOT NULL,
    qty INT NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);

-- Insert sample data into products table
INSERT INTO products (product_code, product_name, product_price, product_unit) VALUES
('P001', 'Red horse liter', 125.00, 'bottle'),
('P002', 'Red horse 500ml', 70.00, 'bottle'),
('P003', 'Coke litro', 45.00, 'can'),
('P004', 'Sprite litro', 45.00, 'can'),
('P005', 'Orange Litro', 75.25, 'can'),
('P006', '555 Sardines', 25.25, 'can'),
('P007', 'Ligo Sardines', 75.25, 'can'),
('P008', 'Pancit Cantoon', 15.00, 'pcs'),
('P009', 'Pancit Noodles', 15.00, 'pcs'),
('P010', 'Ganador', 55.00, 'kilo');

-- Insert sample data into customers table
INSERT INTO customers (customer_name) VALUES
('Jundel Malazarte'),
('Julius Basas'),
('Ronald Jhun Pacquiao');

-- Insert sample data into sales table
INSERT INTO sales (sales_date, customer_id, product_id, qty) VALUES
('2024-10-01', 1, 1, 5),
('2024-10-02', 2, 2, 3),
('2024-10-03', 3, 3, 10);
