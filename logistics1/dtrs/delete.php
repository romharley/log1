
<?php
include '../config.php';

$id = $_GET['id'];
$conn->query("DELETE FROM dtrs_documents WHERE id = $id");
header("Location: index.php");
?>
