<?php include('../header.php'); 
include('../config.php'); 
?>
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Supplier Management</h1>
            <p class="text-gray-600">Manage your supplier relationships and performance</p>
        </div>
        <a href="create.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Add Supplier</a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-sm font-medium text-gray-500">Total Suppliers</h3>
            <p class="text-2xl font-bold text-gray-900">
                <?php 
                $count = $conn->query("SELECT COUNT(*) as total FROM suppliers")->fetch_assoc();
                echo $count['total'];
                ?>
            </p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-sm font-medium text-gray-500">Active Suppliers</h3>
            <p class="text-2xl font-bold text-green-600">
                <?php 
                $active = $conn->query("SELECT COUNT(*) as active FROM suppliers WHERE status='Active'")->fetch_assoc();
                echo $active['active'];
                ?>
            </p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-sm font-medium text-gray-500">Avg Rating</h3>
            <p class="text-2xl font-bold text-blue-600">
                <?php 
                $rating = $conn->query("SELECT AVG(rating) as avg FROM suppliers WHERE status='Active'")->fetch_assoc();
                echo number_format($rating['avg'] ?? 0, 1);
                ?>
            </p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-sm font-medium text-gray-500">Countries</h3>
            <p class="text-2xl font-bold text-purple-600">
                <?php 
                $countries = $conn->query("SELECT COUNT(DISTINCT country) as total FROM suppliers")->fetch_assoc();
                echo $countries['total'];
                ?>
            </p>
        </div>
    </div>

    <!-- Suppliers Table -->
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium">Code</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Company</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Contact</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Country</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Lead Time</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Rating</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Status</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $query = "SELECT * FROM suppliers ORDER BY company_name";
                $result = $conn->query($query);
                
                while ($supplier = $result->fetch_assoc()):
                ?>
                <tr>
                    <td class="px-4 py-3 text-sm font-mono"><?= htmlspecialchars($supplier['supplier_code']) ?></td>
                    <td class="px-4 py-3 text-sm">
                        <div class="font-medium"><?= htmlspecialchars($supplier['company_name']) ?></div>
                        <div class="text-gray-500 text-xs"><?= htmlspecialchars($supplier['contact_person']) ?></div>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <div class="text-xs"><?= htmlspecialchars($supplier['email']) ?></div>
                        <div class="text-xs text-gray-500"><?= htmlspecialchars($supplier['phone']) ?></div>
                    </td>
                    <td class="px-4 py-3 text-sm"><?= htmlspecialchars($supplier['country']) ?></td>
                    <td class="px-4 py-3 text-sm"><?= htmlspecialchars($supplier['lead_time_days']) ?> days</td>
                    <td class="px-4 py-3 text-sm">
                        <div class="flex items-center">
                            <span class="text-yellow-500">★</span>
                            <span class="ml-1"><?= number_format($supplier['rating'], 1) ?></span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <span class="px-2 py-1 text-xs rounded-full <?= $supplier['status'] == 'Active' ? 'bg-green-100 text-green-800' : ($supplier['status'] == 'Inactive' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') ?>">
                            <?= htmlspecialchars($supplier['status']) ?>
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm space-x-2">
                        <a href="view.php?id=<?= $supplier['id'] ?>" class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200">View</a>
                        <a href="edit.php?id=<?= $supplier['id'] ?>" class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200">Edit</a>
                        <a href="performance.php?id=<?= $supplier['id'] ?>" class="inline-block px-3 py-1 bg-purple-100 text-purple-700 rounded hover:bg-purple-200">Performance</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../footer.php'); ?>
