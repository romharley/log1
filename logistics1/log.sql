-- Create Database
CREATE DATABASE logistics_db;
USE logistics_db;

-- 1. Smart Warehousing System (SWS)
CREATE TABLE sws_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    location VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Procurement & Sourcing Management (PSM)
CREATE TABLE psm_procurements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_name VARCHAR(255) NOT NULL,
    item VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    order_date DATE NOT NULL,
    status ENUM('Pending', 'Approved', 'Delivered') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Project Logistics Tracker (PLT)
CREATE TABLE plt_projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_name VARCHAR(255) NOT NULL,
    description TEXT,
    start_date DATE,
    end_date DATE,
    progress_percentage INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Asset Lifecycle & Maintenance (ALMS)
CREATE TABLE alms_assets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    asset_name VARCHAR(255) NOT NULL,
    asset_type VARCHAR(100),
    purchase_date DATE,
    maintenance_date DATE,
    status ENUM('Active', 'Under Maintenance', 'Retired') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Document Tracking & Logistics Records (DTRS)
CREATE TABLE dtrs_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    document_title VARCHAR(255) NOT NULL,
    document_type VARCHAR(100),
    reference_no VARCHAR(100) UNIQUE,
    storage_location VARCHAR(255),
    uploaded_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
