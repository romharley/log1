<?php
include('../config.php');
include('../header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['item_name'] ?? '';
    $qty  = (int)($_POST['quantity'] ?? 0);
    $loc  = $_POST['location'] ?? '';

    $stmt = $conn->prepare("INSERT INTO sws_items (item_name, quantity, location) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $name, $qty, $loc);
    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>
<div class="max-w-3xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">Add New Item</h1>
  <form method="post" class="bg-white p-6 rounded shadow">
    <label class="block mb-2">Item Name</label>
    <input type="text" name="item_name" class="w-full border rounded px-3 py-2 mb-4" required>

    <label class="block mb-2">Quantity</label>
    <input type="number" name="quantity" class="w-full border rounded px-3 py-2 mb-4" required min="0">

    <label class="block mb-2">Location</label>
    <input type="text" name="location" class="w-full border rounded px-3 py-2 mb-4">

    <div class="flex gap-2">
      <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save</button>
      <a href="index.php" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</a>
    </div>
  </form>
</div>
<?php include('../footer.php'); ?>
