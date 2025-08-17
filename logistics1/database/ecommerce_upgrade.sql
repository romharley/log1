-- Ecommerce Management System Database Upgrade
-- Smart Supply Chain & Procurement Management

USE logistics_db;

-- 1. Products & Catalog Management
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    brand VARCHAR(100),
    price DECIMAL(10,2) NOT NULL,
    cost DECIMAL(10,2),
    weight DECIMAL(8,2),
    dimensions VARCHAR(50),
    barcode VARCHAR(50),
    status ENUM('Active', 'Inactive', 'Discontinued') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. Enhanced Inventory Management
CREATE TABLE inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    reserved_quantity INT DEFAULT 0,
    reorder_point INT DEFAULT 0,
    max_stock_level INT DEFAULT 0,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id),
    INDEX idx_product_warehouse (product_id, warehouse_id)
);

-- 3. Suppliers Management
CREATE TABLE suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_code VARCHAR(20) UNIQUE NOT NULL,
    company_name VARCHAR(255) NOT NULL,
    contact_person VARCHAR(100),
    email VARCHAR(255),
    phone VARCHAR(20),
    address TEXT,
    country VARCHAR(50),
    payment_terms VARCHAR(50),
    lead_time_days INT DEFAULT 0,
    rating DECIMAL(3,2) DEFAULT 0.00,
    status ENUM('Active', 'Inactive', 'Suspended') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Purchase Orders
CREATE TABLE purchase_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    po_number VARCHAR(50) UNIQUE NOT NULL,
    supplier_id INT NOT NULL,
    order_date DATE NOT NULL,
    expected_delivery DATE,
    total_amount DECIMAL(12,2) NOT NULL,
    status ENUM('Draft', 'Sent', 'Confirmed', 'Partial', 'Received', 'Cancelled') DEFAULT 'Draft',
    notes TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

-- 5. Purchase Order Items
CREATE TABLE purchase_order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    po_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    received_quantity INT DEFAULT 0,
    FOREIGN KEY (po_id) REFERENCES purchase_orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- 6. Demand Forecasting
CREATE TABLE demand_forecasts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    forecast_date DATE NOT NULL,
    predicted_quantity INT NOT NULL,
    confidence_level DECIMAL(3,2),
    algorithm_used VARCHAR(50),
    actual_quantity INT,
    accuracy_percentage DECIMAL(5,2),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- 7. Supplier Performance Metrics
CREATE TABLE supplier_performance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_id INT NOT NULL,
    metric_type ENUM('Quality', 'Delivery', 'Price', 'Service') NOT NULL,
    score DECIMAL(3,2) NOT NULL,
    period_start DATE NOT NULL,
    period_end DATE NOT NULL,
    notes TEXT,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

-- 8. RFQ Management
CREATE TABLE rfqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rfq_number VARCHAR(50) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    deadline DATE,
    status ENUM('Draft', 'Sent', 'Received', 'Evaluated', 'Awarded', 'Cancelled') DEFAULT 'Draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rfq_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rfq_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    specifications TEXT,
    FOREIGN KEY (rfq_id) REFERENCES rfqs(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- 9. Supplier Quotes
CREATE TABLE supplier_quotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rfq_id INT NOT NULL,
    supplier_id INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    delivery_time INT,
    validity_period INT,
    notes TEXT,
    status ENUM('Pending', 'Accepted', 'Rejected') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rfq_id) REFERENCES rfqs(id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

-- 10. Stock Movements
CREATE TABLE stock_movements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    movement_type ENUM('IN', 'OUT', 'TRANSFER', 'ADJUSTMENT') NOT NULL,
    quantity INT NOT NULL,
    reference_type VARCHAR(50),
    reference_id INT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Insert sample data
INSERT INTO products (sku, name, description, category, brand, price, cost, weight) VALUES
('PROD-001', 'Wireless Mouse', 'Ergonomic wireless mouse with USB receiver', 'Electronics', 'TechBrand', 29.99, 15.00, 0.2),
('PROD-002', 'Laptop Stand', 'Adjustable aluminum laptop stand', 'Accessories', 'OfficePro', 49.99, 25.00, 1.5),
('PROD-003', 'USB-C Cable', '2m USB-C to USB-C charging cable', 'Cables', 'ConnectX', 19.99, 8.00, 0.1);

INSERT INTO suppliers (supplier_code, company_name, contact_person, email, phone, country, lead_time_days, rating) VALUES
('SUP-001', 'Global Electronics Ltd', 'John Smith', 'john@globalelec.com', '+1-555-0101', 'China', 14, 4.5),
('SUP-002', 'Office Solutions Inc', 'Maria Garcia', 'maria@officesol.com', '+1-555-0102', 'USA', 7, 4.8),
('SUP-003', 'TechSupply Co', 'David Lee', 'david@techsupply.com', '+1-555-0103', 'South Korea', 10, 4.3);
