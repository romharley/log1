<?php
include '../config.php';
include('../header.php');
$result = $conn->query("SELECT * FROM alms_assets ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Asset Lifecycle & Maintenance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Asset Lifecycle & Maintenance</h1>
    <a href="create.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Add Asset</a>
    <table class="min-w-full mt-6 bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Type</th>
                <th class="px-4 py-2">Purchase Date</th>
                <th class="px-4 py-2">Maintenance Date</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="border-b">
                <td class="px-4 py-2"><?= $row['id'] ?></td>
                <td class="px-4 py-2"><?= $row['asset_name'] ?></td>
                <td class="px-4 py-2"><?= $row['asset_type'] ?></td>
                <td class="px-4 py-2"><?= $row['purchase_date'] ?></td>
                <td class="px-4 py-2"><?= $row['maintenance_date'] ?></td>
                <td class="px-4 py-2"><?= $row['status'] ?></td>
                <td class="px-4 py-2">
                    <a href="update.php?id=<?= $row['id'] ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this asset?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
