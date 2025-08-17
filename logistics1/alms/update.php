<?php
include '../config.php';
$id = $_GET['id'];
$asset = $conn->query("SELECT * FROM alms_assets WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['asset_name'];
    $type = $_POST['asset_type'];
    $purchase = $_POST['purchase_date'];
    $maintenance = $_POST['maintenance_date'];
    $status = $_POST['status'];
    $conn->query("UPDATE alms_assets SET asset_name='$name', asset_type='$type', purchase_date='$purchase', maintenance_date='$maintenance', status='$status' WHERE id=$id");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Asset</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-lg mx-auto p-6 bg-white shadow rounded mt-10">
    <h1 class="text-2xl font-bold mb-4">Edit Asset</h1>
    <form method="POST">
        <input type="text" name="asset_name" value="<?= $asset['asset_name'] ?>" class="border w-full px-3 py-2 mb-4" required>
        <input type="text" name="asset_type" value="<?= $asset['asset_type'] ?>" class="border w-full px-3 py-2 mb-4">
        <input type="date" name="purchase_date" value="<?= $asset['purchase_date'] ?>" class="border w-full px-3 py-2 mb-4">
        <input type="date" name="maintenance_date" value="<?= $asset['maintenance_date'] ?>" class="border w-full px-3 py-2 mb-4">
        <select name="status" class="border w-full px-3 py-2 mb-4">
            <option <?= $asset['status']=='Active' ? 'selected' : '' ?>>Active</option>
            <option <?= $asset['status']=='Under Maintenance' ? 'selected' : '' ?>>Under Maintenance</option>
            <option <?= $asset['status']=='Retired' ? 'selected' : '' ?>>Retired</option>
        </select>
        <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
</body>
</html>
