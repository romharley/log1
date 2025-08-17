<?php
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $sku = $conn->real_escape_string($_POST['sku']);
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $category = $conn->real_escape_string($_POST['category']);
    $brand = $conn->real_escape_string($_POST['brand']);
    $price = floatval($_POST['price']);
    $cost = !empty($_POST['cost']) ? floatval($_POST['cost']) : 0;
    $weight = !empty($_POST['weight']) ? floatval($_POST['weight']) : 0;
    $dimensions = $conn->real_escape_string($_POST['dimensions']);
    $barcode = $conn->real_escape_string($_POST['barcode']);
    $status = $conn->real_escape_string($_POST['status']);

    // Check if SKU already exists
    $check = $conn->query("SELECT id FROM products WHERE sku = '$sku'");
    if ($check->num_rows > 0) {
        $_SESSION['error'] = "SKU already exists!";
        header("Location: create.php");
        exit;
    }

    // Insert product
    $sql = "INSERT INTO products (sku, name, description, category, brand, price, cost, weight, dimensions, barcode, status) 
            VALUES ('$sku', '$name', '$description', '$category', '$brand', $price, $cost, $weight, '$dimensions', '$barcode', '$status')";
    
    if ($conn->query($sql)) {
        $product_id = $conn->insert_id;
        
        // Handle file uploads
        if (!empty($_FILES['images']['name'][0])) {
            $upload_dir = '../uploads/products/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    $file_name = uniqid() . '_' . basename($_FILES['images']['name'][$key]);
                    $target_path = $upload_dir . $file_name;
                    
                    if (move_uploaded_file($tmp_name, $target_path)) {
                        // Save image path to database (you can create a product_images table)
                        // For now, we'll skip this part
                    }
                }
            }
        }
        
        $_SESSION['success'] = "Product added successfully!";
        header("Location: index.php");
    } else {
        $_SESSION['error'] = "Error adding product: " . $conn->error;
        header("Location: create.php");
    }
} else {
    header("Location: create.php");
}
?>
