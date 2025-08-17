<?php
include '../config.php';
$id = $_GET['id'];
$conn->query("DELETE FROM alms_assets WHERE id=$id");
header("Location: index.php");
