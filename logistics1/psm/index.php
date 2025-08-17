<?php
include('../config.php');
include('../header.php'); // Contains <html>, <head>, sidebar start
?>

<div class="max-w-7xl mx-auto">
  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-3xl font-bold">Procurement & Sourcing Management</h1>
      <p class="text-gray-600">Track procurement and supplier activities here.</p>
    </div>
    <a href="create.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ New Procurement</a>
  </div>

  <div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-2 text-left text-sm font-medium">ID</th>
          <th class="px-4 py-2 text-left text-sm font-medium">Supplier</th>
          <th class="px-4 py-2 text-left text-sm font-medium">Item</th>
          <th class="px-4 py-2 text-left text-sm font-medium">Qty</th>
          <th class="px-4 py-2 text-left text-sm font-medium">Price</th>
          <th class="px-4 py-2 text-left text-sm font-medium">Order Date</th>
          <th class="px-4 py-2 text-left text-sm font-medium">Status</th>
          <th class="px-4 py-2 text-left text-sm font-medium">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <?php
        $q = $conn->query("SELECT * FROM psm_procurements ORDER BY id DESC");
        while ($row = $q->fetch_assoc()):
        ?>
        <tr>
          <td class="px-4 py-3 text-sm"><?= htmlspecialchars($row['id']) ?></td>
          <td class="px-4 py-3 text-sm"><?= htmlspecialchars($row['supplier_name']) ?></td>
          <td class="px-4 py-3 text-sm"><?= htmlspecialchars($row['item']) ?></td>
          <td class="px-4 py-3 text-sm"><?= htmlspecialchars($row['quantity']) ?></td>
          <td class="px-4 py-3 text-sm"><?= number_format($row['price'], 2) ?></td>
          <td class="px-4 py-3 text-sm"><?= htmlspecialchars($row['order_date']) ?></td>
          <td class="px-4 py-3 text-sm"><?= htmlspecialchars($row['status']) ?></td>
          <td class="px-4 py-3 text-sm space-x-2">
            <a href="update.php?id=<?= $row['id'] ?>" class="inline-block px-3 py-1 bg-yellow-400 text-black rounded hover:bg-yellow-500">Edit</a>
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this procurement?')" class="inline-block px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('../footer.php'); ?>
