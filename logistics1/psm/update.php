<?php
include('../config.php');
include('../header.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    echo "<div class='text-red-600'>Invalid ID.</div>";
    include('../footer.php'); exit;
}

$stmt = $conn->prepare("SELECT * FROM psm_procurements WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$item = $res->fetch_assoc();
if (!$item) {
    echo "<div class='text-red-600'>Record not found.</div>";
    include('../footer.php'); exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplier = trim($_POST['supplier_name'] ?? '');
    $iname    = trim($_POST['item'] ?? '');
    $quantity = (int)($_POST['quantity'] ?? 0);
    $price    = (float)($_POST['price'] ?? 0);
    $order_date = $_POST['order_date'] ?? '';
    $status   = $_POST['status'] ?? 'Pending';

    if ($supplier === '') $errors[] = "Supplier name is required.";
    if ($iname === '') $errors[] = "Item is required.";
    if ($quantity < 0) $errors[] = "Quantity must be >= 0.";
    if ($price < 0) $errors[] = "Price must be >= 0.";
    if ($order_date === '') $errors[] = "Order date is required.";
    $allowed_status = ['Pending','Approved','Delivered'];
    if (!in_array($status, $allowed_status)) $status = 'Pending';

    if (empty($errors)) {
        $u = $conn->prepare("UPDATE psm_procurements SET supplier_name=?, item=?, quantity=?, price=?, order_date=?, status=? WHERE id=?");
        $u->bind_param("ssisssi", $supplier, $iname, $quantity, $price, $order_date, $status, $id);
        $u->execute();
        header("Location: index.php");
        exit;
    }
}
?>
<div class="max-w-3xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">Edit Procurement</h1>

  <?php if (!empty($errors)): ?>
    <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded mb-4">
      <ul class="list-disc pl-5">
        <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" class="bg-white p-6 rounded shadow">
    <label class="block mb-2">Supplier Name</label>
    <input type="text" name="supplier_name" class="w-full border rounded px-3 py-2 mb-4" required value="<?= htmlspecialchars($_POST['supplier_name'] ?? $item['supplier_name']) ?>">

    <label class="block mb-2">Item</label>
    <input type="text" name="item" class="w-full border rounded px-3 py-2 mb-4" required value="<?= htmlspecialchars($_POST['item'] ?? $item['item']) ?>">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block mb-2">Quantity</label>
        <input type="number" name="quantity" min="0" class="w-full border rounded px-3 py-2 mb-4" required value="<?= htmlspecialchars($_POST['quantity'] ?? $item['quantity']) ?>">
      </div>
      <div>
        <label class="block mb-2">Price</label>
        <input type="number" name="price" step="0.01" min="0" class="w-full border rounded px-3 py-2 mb-4" required value="<?= htmlspecialchars($_POST['price'] ?? $item['price']) ?>">
      </div>
      <div>
        <label class="block mb-2">Order Date</label>
        <input type="date" name="order_date" class="w-full border rounded px-3 py-2 mb-4" required value="<?= htmlspecialchars($_POST['order_date'] ?? $item['order_date']) ?>">
      </div>
    </div>

    <label class="block mb-2">Status</label>
    <select name="status" class="w-full border rounded px-3 py-2 mb-4">
      <?php foreach (['Pending','Approved','Delivered'] as $s): ?>
        <?php $selected = (($_POST['status'] ?? $item['status']) === $s) ? 'selected' : ''; ?>
        <option value="<?= $s ?>" <?= $selected ?>><?= $s ?></option>
      <?php endforeach; ?>
    </select>

    <div class="flex gap-2">
      <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
      <a href="index.php" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</a>
    </div>
  </form>
</div>
<?php include('../footer.php'); ?>
