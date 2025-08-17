<?php
include '../config.php';
include('../header.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['asset_name'];
    $type = $_POST['asset_type'];
    $purchase = $_POST['purchase_date'];
    $maintenance = $_POST['maintenance_date'];
    $status = $_POST['status'];
    $conn->query("INSERT INTO alms_assets (asset_name, asset_type, purchase_date, maintenance_date, status) 
                  VALUES ('$name', '$type', '$purchase', '$maintenance', '$status')");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Asset</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-lg mx-auto p-6 bg-white shadow rounded mt-10">
    <h1 class="text-2xl font-bold mb-4">Add Asset</h1>
    <form method="POST">
        <input type="text" name="asset_name" placeholder="Asset Name" class="border w-full px-3 py-2 mb-4" required>
        <input type="text" name="asset_type" placeholder="Asset Type" class="border w-full px-3 py-2 mb-4">
        <input type="date" name="purchase_date" class="border w-full px-3 py-2 mb-4">
        <input type="date" name="maintenance_date" class="border w-full px-3 py-2 mb-4">
        <select name="status" class="border w-full px-3 py-2 mb-4">
            <option value="Active">Active</option>
            <option value="Under Maintenance">Under Maintenance</option>
            <option value="Retired">Retired</option>
        </select>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Save</button>
    </form>
</div>
</body>
</html>
