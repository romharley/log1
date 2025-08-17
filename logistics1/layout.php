<?php
// layout.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $title ?? 'Logistics System' ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

  <!-- Sidebar -->
  <aside class="w-64 bg-gray-900 text-white min-h-screen">
    <div class="p-4 text-2xl font-bold border-b border-gray-700">Logistics System</div>
    <nav class="p-4 space-y-2">
      <a href="/logistics1/dashboard/analytics.php" class="block px-4 py-2 rounded hover:bg-gray-700">Dashboard</a>
      <a href="/logistics1/products/index.php" class="block px-4 py-2 rounded hover:bg-gray-700">Products</a>
      <a href="/logistics1/suppliers/index.php" class="block px-4 py-2 rounded hover:bg-gray-700">Suppliers</a>
      <a href="/logistics1/sws/index.php" class="block px-4 py-2 rounded hover:bg-gray-700">Smart Warehousing</a>
      <a href="/logistics1/psm/index.php" class="block px-4 py-2 rounded hover:bg-gray-700">Procurement & Sourcing</a>
      <a href="/logistics1/plt/index.php" class="block px-4 py-2 rounded hover:bg-gray-700">Project Logistics Tracker</a>
      <a href="/logistics1/alms/index.php" class="block px-4 py-2 rounded hover:bg-gray-700">Asset Lifecycle</a>
      <a href="/logistics1/dtrs/index.php" class="block px-4 py-2 rounded hover:bg-gray-700">Document Tracking</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-6 overflow-auto">
    <?php
      // This will include the page-specific content passed via $content
      if (isset($content)) {
        echo $content;
      } else {
        echo "<h1 class='text-2xl font-bold'>No content provided.</h1>";
      }
    ?>
  </main>

</body>
</html>

