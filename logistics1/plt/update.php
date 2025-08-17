<?php
include('../config.php');
include('../header.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) { echo "<div class='text-red-600'>Invalid ID.</div>"; include('../footer.php'); exit; }

$stmt = $conn->prepare("SELECT * FROM plt_projects WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$project = $res->fetch_assoc();
if (!$project) { echo "<div class='text-red-600'>Project not found.</div>"; include('../footer.php'); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['project_name'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $start = $_POST['start_date'] ?? null;
    $end = $_POST['end_date'] ?? null;
    $progress = isset($_POST['progress_percentage']) ? (int)$_POST['progress_percentage'] : 0;

    if ($name === '') $errors[] = "Project name is required.";
    if ($progress < 0 || $progress > 100) $errors[] = "Progress must be between 0 and 100.";
    if ($start && $end && ($start > $end)) $errors[] = "Start date cannot be after end date.";

    if (empty($errors)) {
        $u = $conn->prepare("UPDATE plt_projects SET project_name = ?, description = ?, start_date = ?, end_date = ?, progress_percentage = ? WHERE id = ?");
        $u->bind_param("ssssii", $name, $desc, $start, $end, $progress, $id);
        $u->execute();
        header("Location: index.php");
        exit;
    }
}
?>
<div class="max-w-3xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">Edit Project</h1>

  <?php if (!empty($errors)): ?>
    <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded mb-4">
      <ul class="list-disc pl-5">
        <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" class="bg-white p-6 rounded shadow">
    <label class="block mb-2">Project Name</label>
    <input type="text" name="project_name" class="w-full border rounded px-3 py-2 mb-4" required value="<?= htmlspecialchars($_POST['project_name'] ?? $project['project_name']) ?>">

    <label class="block mb-2">Description</label>
    <textarea name="description" rows="4" class="w-full border rounded px-3 py-2 mb-4"><?= htmlspecialchars($_POST['description'] ?? $project['description']) ?></textarea>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block mb-2">Start Date</label>
        <input type="date" name="start_date" class="w-full border rounded px-3 py-2 mb-4" value="<?= htmlspecialchars($_POST['start_date'] ?? $project['start_date']) ?>">
      </div>
      <div>
        <label class="block mb-2">End Date</label>
        <input type="date" name="end_date" class="w-full border rounded px-3 py-2 mb-4" value="<?= htmlspecialchars($_POST['end_date'] ?? $project['end_date']) ?>">
      </div>
      <div>
        <label class="block mb-2">Progress (%)</label>
        <input type="number" name="progress_percentage" min="0" max="100" class="w-full border rounded px-3 py-2 mb-4" value="<?= htmlspecialchars($_POST['progress_percentage'] ?? $project['progress_percentage']) ?>">
      </div>
    </div>

    <div class="flex gap-2">
      <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
      <a href="index.php" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</a>
    </div>
  </form>
</div>
<?php include('../footer.php'); ?>
