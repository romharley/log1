<?php
include('../config.php');
include('../header.php');

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplier = trim($_POST['supplier_name'] ?? '');
    $item     = trim($_POST['item'] ?? '');
    $quantity = (int)($_POST['quantity'] ?? 0);
    $price    = (float)($_POST['price'] ?? 0);
    $order_date = $_POST['order_date'] ?? '';
    $status   = $_POST['status'] ?? 'Pending';

    if ($supplier === '') $errors[] = "Supplier name is required.";
    if ($item === '') $errors[] = "Item is required.";
    if ($quantity < 0) $errors[] = "Quantity must be 0 or greater.";
    if ($price < 0) $errors[] = "Price must be 0 or greater.";
    if ($order_date === '') $errors[] = "Order date is required.";
    $allowed_status = ['Pending','Approved','Delivered'];
    if (!in_array($status, $allowed_status)) $status = 'Pending';

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO psm_procurements (supplier_name, item, quantity, price, order_date, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisds", $supplier, $item, $quantity, $price, $order_date, $status);
        $stmt->execute();
        header("Location: index.php");
        exit;
    }
}
?>
<div class="max-w-3xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">New Procurement</h1>

  <?php if (!empty($errors)): ?>
    <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded mb-4">
      <ul class="list-disc pl-5">
        <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" class="bg-white p-6 rounded shadow">
    <label class="block mb-2">Supplier Name</label>
    <input type="text" name="supplier_name" class="w-full border rounded px-3 py-2 mb-4" required value="<?= htmlspecialchars($_POST['supplier_name'] ?? '') ?>">

    <label class="block mb-2">Item</label>
    <input type="text" name="item" class="w-full border rounded px-3 py-2 mb-4" required value="<?= htmlspecialchars($_POST['item'] ?? '') ?>">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block mb-2">Quantity</label>
        <input type="number" name="quantity" min="0" class="w-full border rounded px-3 py-2 mb-4" required value="<?= htmlspecialchars($_POST['quantity'] ?? '0') ?>">
      </div>
      <div>
        <label class="block mb-2">Price</label>
        <input type="number" name="price" step="0.01" min="0" class="w-full border rounded px-3 py-2 mb-4" required value="<?= htmlspecialchars($_POST['price'] ?? '0.00') ?>">
      </div>
      <div>
        <label class="block mb-2">Order Date</label>
        <input type="date" name="order_date" class="w-full border rounded px-3 py-2 mb-4" required value="<?= htmlspecialchars($_POST['order_date'] ?? date('Y-m-d')) ?>">
      </div>
    </div>

    <label class="block mb-2">Status</label>
    <select name="status" class="w-full border rounded px-3 py-2 mb-4">
      <?php foreach (['Pending','Approved','Delivered'] as $s): ?>
        <option value="<?= $s ?>" <?= (($_POST['status'] ?? '') === $s) ? 'selected' : '' ?>><?= $s ?></option>
      <?php endforeach; ?>
    </select>

    <div class="flex gap-2">
      <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save</button>
      <a href="index.php" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</a>
    </div>
  </form>
</div>
<?php include('../footer.php'); ?>
