<?php
include('../config.php');
include('../header.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$item = null;
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM sws_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $item = $res->fetch_assoc();
}

if (!$item) {
    echo "<div class='text-red-600'>Item not found.</div>";
    include('../footer.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['item_name'] ?? '';
    $qty  = (int)($_POST['quantity'] ?? 0);
    $loc  = $_POST['location'] ?? '';

    $stmt = $conn->prepare("UPDATE sws_items SET item_name = ?, quantity = ?, location = ? WHERE id = ?");
    $stmt->bind_param("sisi", $name, $qty, $loc, $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>
<div class="max-w-3xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">Edit Item</h1>
  <form method="post" class="bg-white p-6 rounded shadow">
    <label class="block mb-2">Item Name</label>
    <input type="text" name="item_name" class="w-full border rounded px-3 py-2 mb-4" value="<?= htmlspecialchars($item['item_name']) ?>" required>

    <label class="block mb-2">Quantity</label>
    <input type="number" name="quantity" class="w-full border rounded px-3 py-2 mb-4" value="<?= htmlspecialchars($item['quantity']) ?>" required min="0">

    <label class="block mb-2">Location</label>
    <input type="text" name="location" class="w-full border rounded px-3 py-2 mb-4" value="<?= htmlspecialchars($item['location']) ?>">

    <div class="flex gap-2">
      <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
      <a href="index.php" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</a>
    </div>
  </form>
</div>
<?php include('../footer.php'); ?>
