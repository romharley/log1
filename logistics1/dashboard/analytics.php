<?php
// Include header and database connection before any query
include('../header.php');
    
require_once __DIR__ . '/../config.php'; // Adjust path if needed

// Safety check: if connection fails, stop execution
if (!isset($conn) || $conn->connect_error) {
    die("Database connection failed: " . ($conn->connect_error ?? 'Unknown error'));
}
?>

<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Analytics Dashboard</h1>
        <p class="text-gray-600">Smart supply chain and procurement insights</p>
    </div>

    <!-- Key Metrics Row -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Revenue</h3>
                    <p class="text-2xl font-bold text-gray-900">
                        ₱<?php
                        $revenue = $conn->query("
                            SELECT SUM(price * (SELECT COALESCE(SUM(quantity), 0) 
                            FROM inventory WHERE product_id = products.id)) as total 
                            FROM products WHERE status='Active'
                        ")->fetch_assoc();
                        echo number_format($revenue['total'] ?? 0, 2);
                        ?>
                    </p>
                </div>
            </div>
        </div>

      <div class="bg-white p-6 rounded shadow">
    <div class="flex items-center">
        <div class="p-3 rounded-full bg-green-100 text-green-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
        </div>
        <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500">On-Time Delivery</h3>
            <p class="text-2xl font-bold text-gray-900">
                <?php
                $percentage = 0; // default
                
                if ($conn) {
                    try {
                        $query = "
                            SELECT 
                                (COUNT(CASE WHEN status = 'Delivered' THEN 1 END) * 100.0 / NULLIF(COUNT(*), 0)) AS percentage
                            FROM psm_procurements
                        ";
                        $result = $conn->query($query);
                        if ($result) {
                            $row = $result->fetch_assoc();
                            $percentage = $row['percentage'] ?? 0;
                        }
                    } catch (Exception $e) {
                        $percentage = 0; // table missing or query failed
                    }
                }
                
                echo number_format($percentage, 1) . '%';
                ?>
            </p>
        </div>
    </div>
</div>

        <div class="bg-white p-6 rounded shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Inventory Turnover</h3>
                    <p class="text-2xl font-bold text-gray-900">
                        <?php
                        $turnover = $conn->query("SELECT AVG(quantity) as avg_inventory FROM inventory")->fetch_assoc();
                        echo number_format($turnover['avg_inventory'] ?? 0, 0);
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Active Suppliers</h3>
                    <p class="text-2xl font-bold text-gray-900">
                        <?php
                        $suppliers = $conn->query("SELECT COUNT(*) as total FROM suppliers WHERE status='Active'")->fetch_assoc();
                        echo $suppliers['total'];
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Procurement Status Chart -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Procurement Status</h3>
            <canvas id="procurementChart" width="400" height="200"></canvas>
        </div>

        <!-- Top Products -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Top Products by Revenue</h3>
            <div class="space-y-3">
                <?php
                $top_products = $conn->query("
                    SELECT p.name, p.price, SUM(po.quantity) as total_sold,
                           (p.price * SUM(po.quantity)) as revenue
                    FROM products p
                    JOIN purchase_order_items po ON p.id = po.product_id
                    GROUP BY p.id
                    ORDER BY revenue DESC
                    LIMIT 5
                ");
                while ($product = $top_products->fetch_assoc()):
                ?>
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-medium"><?= htmlspecialchars($product['name']) ?></p>
                        <p class="text-sm text-gray-500"><?= $product['total_sold'] ?> units sold</p>
                    </div>
                    <p class="font-semibold">$<?= number_format($product['revenue'], 2) ?></p>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <!-- Supplier Performance -->
    <div class="bg-white p-6 rounded shadow mb-8">
        <h3 class="text-lg font-semibold mb-4">Supplier Performance</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium">Supplier</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Rating</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">On-Time %</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Quality Score</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Total Orders</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
            $suppliers = $conn->query("
    SELECT s.company_name, s.rating,
           (SELECT COUNT(*) FROM psm_procurements WHERE supplier_id = s.id AND status = 'Delivered') as delivered,
           (SELECT COUNT(*) FROM psm_procurements WHERE supplier_id = s.id) as total_orders
    FROM suppliers s
    WHERE s.status = 'Active'
    ORDER BY s.rating DESC
    LIMIT 10
");

while ($supplier = $suppliers->fetch_assoc()):
    $on_time_pct = $supplier['total_orders'] > 0 
        ? ($supplier['delivered'] / $supplier['total_orders']) * 100 
        : 0;
?>

                    <tr>
                        <td class="px-4 py-3 text-sm"><?= htmlspecialchars($supplier['company_name']) ?></td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center">
                                <span class="text-yellow-500">★</span>
                                <span class="ml-1"><?= number_format($supplier['rating'], 1) ?></span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm"><?= number_format($on_time_pct, 1) ?>%</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">92%</span>
                        </td>
                        <td class="px-4 py-3 text-sm"><?= $supplier['total_orders'] ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Alerts -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-4">Smart Alerts</h3>
        <div class="space-y-3">
            <?php
            $low_stock = $conn->query("
                SELECT p.name, i.quantity, i.reorder_point
                FROM products p
                JOIN inventory i ON p.id = i.product_id
                WHERE i.quantity <= i.reorder_point
                ORDER BY i.quantity ASC
                LIMIT 5
            ");
            while ($alert = $low_stock->fetch_assoc()):
            ?>
            <div class="flex items-center p-3 bg-red-50 border-l-4 border-red-400">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        <strong>Low Stock Alert:</strong> <?= htmlspecialchars($alert['name']) ?> has only <?= $alert['quantity'] ?> units left (Reorder: <?= $alert['reorder_point'] ?>)
                    </p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('procurementChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Approved', 'Delivered', 'Cancelled'],
        datasets: [{
            data: [
                <?php
                $pending   = $conn->query("SELECT COUNT(*) as count FROM psm_procurements WHERE status='Pending'")->fetch_assoc();
                $approved  = $conn->query("SELECT COUNT(*) as count FROM psm_procurements WHERE status='Approved'")->fetch_assoc();
                $delivered = $conn->query("SELECT COUNT(*) as count FROM psm_procurements WHERE status='Delivered'")->fetch_assoc();
                $cancelled = $conn->query("SELECT COUNT(*) as count FROM psm_procurements WHERE status='Cancelled'")->fetch_assoc();
                echo ($pending['count'] ?? 0) . ',' . ($approved['count'] ?? 0) . ',' . ($delivered['count'] ?? 0) . ',' . ($cancelled['count'] ?? 0);
                ?>
            ],
            backgroundColor: ['#FCD34D', '#60A5FA', '#34D399', '#F87171']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

<?php include('../footer.php'); ?>
