<?php
include '../config.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM dtrs_documents WHERE id = $id");
$doc = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['document_title'];
    $type = $_POST['document_type'];
    $ref = $_POST['reference_no'];
    $location = $_POST['storage_location'];
    $uploaded = $_POST['uploaded_date'];

    $stmt = $conn->prepare("UPDATE dtrs_documents SET document_title=?, document_type=?, reference_no=?, storage_location=?, uploaded_date=? WHERE id=?");
    $stmt->bind_param("sssssi", $title, $type, $ref, $location, $uploaded, $id);
    $stmt->execute();
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto px-6 py-6">
    <h1 class="text-2xl font-bold mb-4">✏️ Edit Document</h1>
    <form method="POST" class="bg-white p-6 rounded shadow">
        <input type="text" name="document_title" value="<?= htmlspecialchars($doc['document_title']) ?>" class="border p-2 w-full mb-2" required>
        <input type="text" name="document_type" value="<?= htmlspecialchars($doc['document_type']) ?>" class="border p-2 w-full mb-2" required>
        <input type="text" name="reference_no" value="<?= htmlspecialchars($doc['reference_no']) ?>" class="border p-2 w-full mb-2" required>
        <input type="text" name="storage_location" value="<?= htmlspecialchars($doc['storage_location']) ?>" class="border p-2 w-full mb-2">
        <input type="date" name="uploaded_date" value="<?= htmlspecialchars($doc['uploaded_date']) ?>" class="border p-2 w-full mb-2" required>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
        <a href="index.php" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
</body>
</html>
