<?php
include '../config.php';
include('../header.php');

// Fetch all documents
$result = $conn->query("SELECT * FROM dtrs_documents ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DTRS - Document Tracking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto px-6 py-6">
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Document Tracking & Records</h1>
        <a href="create.php" class="bg-blue-500 text-white px-4 py-2 rounded">➕ Add Document</a>
    </div>
    <table class="min-w-full bg-white rounded shadow">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Type</th>
                <th class="px-4 py-2">Reference No</th>
                <th class="px-4 py-2">Location</th>
                <th class="px-4 py-2">Uploaded</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr class="border-b">
                    <td class="px-4 py-2"><?= htmlspecialchars($row['document_title']) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($row['document_type']) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($row['reference_no']) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($row['storage_location']) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($row['uploaded_date']) ?></td>
                    <td class="px-4 py-2">
                        <a href="update.php?id=<?= $row['id'] ?>" class="text-yellow-500">✏️ Edit</a> |
                        <a href="delete.php?id=<?= $row['id'] ?>" class="text-red-500" onclick="return confirm('Delete this document?');">🗑️ Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
