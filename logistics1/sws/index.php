<?php
include('../config.php');
include('../header.php');
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Smart Warehousing System</h1>
    <a href="create.php" class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-semibold px-5 py-3 rounded-lg shadow-lg hover:from-purple-600 hover:to-indigo-700 transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
      </svg>
      Add Item
    </a>
  </div>

  <div class="overflow-x-auto rounded-lg shadow-lg border border-gray-200 bg-white">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">ID</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Item Name</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Quantity</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Location</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Created At</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php
        $result = $conn->query("SELECT * FROM sws_items ORDER BY id DESC");
        while ($row = $result->fetch_assoc()):
        ?>
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($row['id']) ?></td>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($row['item_name']) ?></td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($row['quantity']) ?></td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($row['location']) ?></td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
          <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
            <a href="update.php?id=<?= $row['id'] ?>" class="inline-flex items-center px-3 py-1 rounded-md bg-yellow-400 text-yellow-900 hover:bg-yellow-500 hover:text-white transition font-semibold">
              Edit
            </a>
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this item?')" class="inline-flex items-center px-3 py-1 rounded-md bg-red-600 text-white hover:bg-red-700 transition font-semibold">
              Delete
            </a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('../footer.php'); ?>
