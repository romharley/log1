<?php
include('../config.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM sws_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: index.php");
exit;
