<?php include('../header.php'); 
include ('../config.php'); ?>

<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Product Catalog</h1>
            <p class="text-gray-600">Manage your ecommerce product catalog</p>
        </div>
        <a href="create.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add Product</a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-sm font-medium text-gray-500">Total Products</h3>
            <p class="text-2xl font-bold text-gray-900">
                <?php 
                $count = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc();
                echo $count['total'];
                ?>
            </p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-sm font-medium text-gray-500">Active Products</h3>
            <p class="text-2xl font-bold text-green-600">
                <?php 
                $active = $conn->query("SELECT COUNT(*) as active FROM products WHERE status='Active'")->fetch_assoc();
                echo $active['active'];
                ?>
            </p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-sm font-medium text-gray-500">Total Value</h3>
            <p class="text-2xl font-bold text-blue-600">
                $<?php 
                $value = $conn->query("SELECT SUM(price) as total FROM products WHERE status='Active'")->fetch_assoc();
                echo number_format($value['total'] ?? 0, 2);
                ?>
            </p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-sm font-medium text-gray-500">Categories</h3>
            <p class="text-2xl font-bold text-purple-600">
                <?php 
                $categories = $conn->query("SELECT COUNT(DISTINCT category) as total FROM products")->fetch_assoc();
                echo $categories['total'];
                ?>
            </p>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white p-4 rounded shadow mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
            <input type="text" name="search" placeholder="Search products..." 
                   class="flex-1 min-w-0 px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <select name="category" class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Categories</option>
                <?php
                $cats = $conn->query("SELECT DISTINCT category FROM products ORDER BY category");
                while($cat = $cats->fetch_assoc()):
                ?>
                <option value="<?= htmlspecialchars($cat['category']) ?>" 
                    <?= ($_GET['category'] ?? '') == $cat['category'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['category']) ?>
                </option>
                <?php endwhile; ?>
            </select>
            <select name="status" class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="Active" <?= ($_GET['status'] ?? '') == 'Active' ? 'selected' : '' ?>>Active</option>
                <option value="Inactive" <?= ($_GET['status'] ?? '') == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                <option value="Discontinued" <?= ($_GET['status'] ?? '') == 'Discontinued' ? 'selected' : '' ?>>Discontinued</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium">SKU</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Product</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Category</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Price</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Cost</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Margin</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Status</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $where = [];
                if (!empty($_GET['search'])) {
                    $search = $conn->real_escape_string($_GET['search']);
                    $where[] = "(name LIKE '%$search%' OR sku LIKE '%$search%' OR description LIKE '%$search%')";
                }
                if (!empty($_GET['category'])) {
                    $category = $conn->real_escape_string($_GET['category']);
                    $where[] = "category = '$category'";
                }
                if (!empty($_GET['status'])) {
                    $status = $conn->real_escape_string($_GET['status']);
                    $where[] = "status = '$status'";
                }
                
                $where_clause = $where ? "WHERE " . implode(" AND ", $where) : "";
                $query = "SELECT * FROM products $where_clause ORDER BY created_at DESC";
                $result = $conn->query($query);
                
                while ($product = $result->fetch_assoc()):
                    $margin = (($product['price'] - $product['cost']) / $product['price']) * 100;
                ?>
                <tr>
                    <td class="px-4 py-3 text-sm font-mono"><?= htmlspecialchars($product['sku']) ?></td>
                    <td class="px-4 py-3 text-sm">
                        <div class="font-medium"><?= htmlspecialchars($product['name']) ?></div>
                        <div class="text-gray-500 text-xs"><?= htmlspecialchars(substr($product['description'], 0, 50)) ?>...</div>
                    </td>
                    <td class="px-4 py-3 text-sm"><?= htmlspecialchars($product['category']) ?></td>
                    <td class="px-4 py-3 text-sm font-semibold">$<?= number_format($product['price'], 2) ?></td>
                    <td class="px-4 py-3 text-sm">$<?= number_format($product['cost'], 2) ?></td>
                    <td class="px-4 py-3 text-sm">
                        <span class="px-2 py-1 text-xs rounded-full <?= $margin > 50 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                            <?= number_format($margin, 1) ?>%
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <span class="px-2 py-1 text-xs rounded-full <?= $product['status'] == 'Active' ? 'bg-green-100 text-green-800' : ($product['status'] == 'Inactive' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') ?>">
                            <?= htmlspecialchars($product['status']) ?>
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm space-x-2">
                        <a href="view.php?id=<?= $product['id'] ?>" class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200">View</a>
                        <a href="edit.php?id=<?= $product['id'] ?>" class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200">Edit</a>
                        <a href="delete.php?id=<?= $product['id'] ?>" onclick="return confirm('Delete this product?')" class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../footer.php'); ?>
