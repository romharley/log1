<?php
include('../config.php');
include('../header.php');
?>
<div class="max-w-7xl mx-auto">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Project Logistics Tracker</h1>
    <a href="create.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ New Project</a>
  </div>

  <div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full divide-y">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-2 text-left text-sm font-medium">ID</th>
          <th class="px-4 py-2 text-left text-sm font-medium">Project Name</th>
          <th class="px-4 py-2 text-left text-sm font-medium">Start</th>
          <th class="px-4 py-2 text-left text-sm font-medium">End</th>
          <th class="px-4 py-2 text-left text-sm font-medium">Progress</th>
          <th class="px-4 py-2 text-left text-sm font-medium">Created At</th>
          <th class="px-4 py-2 text-left text-sm font-medium">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y">
<?php
$q = $conn->query("SELECT * FROM plt_projects ORDER BY id DESC");
while ($row = $q->fetch_assoc()):
?>
        <tr>
          <td class="px-4 py-3 text-sm"><?= htmlspecialchars($row['id']) ?></td>
          <td class="px-4 py-3 text-sm"><?= htmlspecialchars($row['project_name']) ?></td>
          <td class="px-4 py-3 text-sm"><?= htmlspecialchars($row['start_date']) ?></td>
          <td class="px-4 py-3 text-sm"><?= htmlspecialchars($row['end_date']) ?></td>
          <td class="px-4 py-3 text-sm">
            <div class="w-48 bg-gray-200 rounded-full overflow-hidden">
              <div class="h-3 rounded-full" style="width: <?= (int)$row['progress_percentage'] ?>%; background: linear-gradient(90deg,#10b981,#3b82f6)"></div>
            </div>
            <div class="text-xs text-gray-600 mt-1"><?= (int)$row['progress_percentage'] ?>%</div>
          </td>
          <td class="px-4 py-3 text-sm"><?= htmlspecialchars($row['created_at']) ?></td>
          <td class="px-4 py-3 text-sm">
            <a href="update.php?id=<?= $row['id'] ?>" class="inline-block px-3 py-1 mr-2 bg-yellow-400 text-black rounded hover:bg-yellow-500">Edit</a>
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this project?')" class="inline-block px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</a>
          </td>
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include('../footer.php'); ?>
