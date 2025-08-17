<?php
include '../config.php';
include('../header.php'); // Contains <html>, <head>, sidebar start
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['document_title'];
    $type = $_POST['document_type'];
    $ref = $_POST['reference_no'];
    $location = $_POST['storage_location'];
    $uploaded = $_POST['uploaded_date'];

    $stmt = $conn->prepare("INSERT INTO dtrs_documents (document_title, document_type, reference_no, storage_location, uploaded_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $type, $ref, $location, $uploaded);
    $stmt->execute();
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto px-6 py-6">
    <h1 class="text-2xl font-bold mb-4">➕ Add New Document</h1>
    <form method="POST" class="bg-white p-6 rounded shadow">
        <input type="text" name="document_title" placeholder="Document Title" class="border p-2 w-full mb-2" required>
        <input type="text" name="document_type" placeholder="Document Type" class="border p-2 w-full mb-2" required>
        <input type="text" name="reference_no" placeholder="Reference Number" class="border p-2 w-full mb-2" required>
        <input type="text" name="storage_location" placeholder="Storage Location" class="border p-2 w-full mb-2">
        <input type="date" name="uploaded_date" class="border p-2 w-full mb-2" required>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
        <a href="index.php" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
</body>
</html>
