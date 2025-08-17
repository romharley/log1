<?php
// Ecommerce Management System Setup Script
// Run this script to initialize the smart supply chain and procurement management system

include('config.php');

echo "<h1>Ecommerce Management System Setup</h1>";
echo "<pre>";

// Step 1: Create database tables
echo "Step 1: Creating ecommerce database tables...\n";
$sql_file = 'database/ecommerce_upgrade.sql';
if (file_exists($sql_file)) {
    $sql = file_get_contents($sql_file);
    $queries = explode(';', $sql);
    
    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            if ($conn->query($query)) {
                echo "✓ Query executed successfully\n";
            } else {
                echo "✗ Error: " . $conn->error . "\n";
            }
        }
    }
} else {
    echo "✗ SQL file not found: $sql_file\n";
}

// Step 2: Create necessary directories
echo "\nStep 2: Creating directories...\n";
$directories = [
    'uploads',
    'uploads/products',
    'uploads/suppliers',
    'uploads/documents',
    'reports',
    'exports'
];

foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        if (mkdir($dir, 0777, true)) {
            echo "✓ Created directory: $dir\n";
        } else {
            echo "✗ Failed to create directory: $dir\n";
        }
    } else {
        echo "✓ Directory already exists: $dir\n";
    }
}

// Step 3: Create sample data
echo "\nStep 3: Creating sample data...\n";

// Check if products already exist
$product_count = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc();
if ($product_count['total'] == 0) {
    $sample_products = [
        ['SKU-001', 'Wireless Headphones', 'Premium noise-cancelling headphones', 'Electronics', 'AudioTech', 199.99, 120.00, 0.3],
        ['SKU-002', 'Smart Watch', 'Fitness tracking smartwatch', 'Electronics', 'TechWear', 299.99, 180.00, 0.2],
        ['SKU-003', 'Laptop Backpack', 'Water-resistant laptop backpack', 'Accessories', 'CarryPro', 79.99, 40.00, 1.2],
        ['SKU-004', 'USB-C Hub', '7-in-1 USB-C hub adapter', 'Electronics', 'ConnectX', 49.99, 25.00, 0.1],
        ['SKU-005', 'Wireless Mouse', 'Ergonomic wireless mouse', 'Electronics', 'MouseTech', 29.99, 15.00, 0.2]
    ];
    
    foreach ($sample_products as $product) {
        $sql = "INSERT INTO products (sku, name, description, category, brand, price, cost, weight) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssddd", ...$product);
        $stmt->execute();
    }
    echo "✓ Sample products created\n";
} else {
    echo "✓ Products already exist\n";
}

// Step 4: Create inventory records
echo "\nStep 4: Setting up inventory...\n";
$inventory_check = $conn->query("SELECT COUNT(*) as total FROM inventory")->fetch_assoc();
if ($inventory_check['total'] == 0) {
    $products = $conn->query("SELECT id FROM products");
    while ($product = $products->fetch_assoc()) {
        $reorder_point = rand(10, 50);
        $max_stock = $reorder_point * 3;
        $current_stock = rand($reorder_point, $max_stock);
        
        $sql = "INSERT INTO inventory (product_id, warehouse_id, quantity, reorder_point, max_stock_level) 
                VALUES (?, 1, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $product['id'], $current_stock, $reorder_point, $max_stock);
        $stmt->execute();
    }
    echo "✓ Inventory records created\n";
} else {
    echo "✓ Inventory already exists\n";
}

// Step 5: Create sample suppliers
echo "\nStep 5: Creating sample suppliers...\n";
$supplier_count = $conn->query("SELECT COUNT(*) as total FROM suppliers")->fetch_assoc();
if ($supplier_count['total'] <= 3) {
    $sample_suppliers = [
        ['SUP-001', 'Global Electronics Ltd', 'John Smith', 'john@globalelec.com', '+86-21-5555-0101', 'Shanghai, China', 14, 4.5],
        ['SUP-002', 'Tech Components Inc', 'Sarah Johnson', 'sarah@techcomp.com', '+1-555-0202', 'California, USA', 7, 4.8],
        ['SUP-003', 'Asian Manufacturing Co', 'David Lee', 'david@asianmfg.com', '+82-2-5555-0303', 'Seoul, South Korea', 10, 4.3],
        ['SUP-004', 'European Supply Chain', 'Maria Garcia', 'maria@eurosupply.com', '+49-30-5555-0404', 'Berlin, Germany', 12, 4.6],
        ['SUP-005', 'Pacific Trading Company', 'Kenji Tanaka', 'kenji@pacifictrade.com', '+81-3-5555-0505', 'Tokyo, Japan', 8, 4.7]
    ];
    
    foreach ($sample_suppliers as $supplier) {
        $sql = "INSERT INTO suppliers (supplier_code, company_name, contact_person, email, phone, address, lead_time_days, rating) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssidi", ...$supplier);
        $stmt->execute();
    }
    echo "✓ Sample suppliers created\n";
} else {
    echo "✓ Suppliers already exist\n";
}

// Step 6: Create sample purchase orders
echo "\nStep 6: Creating sample purchase orders...\n";
$po_count = $conn->query("SELECT COUNT(*) as total FROM purchase_orders")->fetch_assoc();
if ($po_count['total'] == 0) {
    $suppliers = $conn->query("SELECT id FROM suppliers");
    while ($supplier = $suppliers->fetch_assoc()) {
        for ($i = 0; $i < 3; $i++) {
            $po_number = 'PO-' . date('Y') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            $total_amount = rand(1000, 10000);
            $order_date = date('Y-m-d', strtotime("-".rand(1,30)." days"));
            $expected_delivery = date('Y-m-d', strtotime($order_date . "+".rand(7,30)." days"));
            
            $sql = "INSERT INTO purchase_orders (po_number, supplier_id, order_date, expected_delivery, total_amount, status) 
                    VALUES (?, ?, ?, ?, ?, 'Delivered')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sissd", $po_number, $supplier['id'], $order_date, $expected_delivery, $total_amount);
            $stmt->execute();
        }
    }
    echo "✓ Sample purchase orders created\n";
} else {
    echo "✓ Purchase orders already exist\n";
}

echo "\n✅ Ecommerce Management System Setup Complete!\n";
echo "\nNext steps:\n";
echo "1. Run the database upgrade: mysql -u root -p logistics_db < database/ecommerce_upgrade.sql\n";
echo "2. Access the system at: http://localhost/logistics1/\n";
echo "3. New features available:\n";
echo "   - Product Catalog Management\n";
echo "   - Supplier Relationship Management\n";
echo "   - Smart Analytics Dashboard\n";
echo "   - Inventory Optimization\n";
echo "   - Procurement Automation\n";

echo "</pre>";
?>
