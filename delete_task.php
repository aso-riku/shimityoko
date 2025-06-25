<?php
session_start();
require_once "connectDB.php";
$pdo = connectDB();


$task_id = $_GET['id'] ?? '';
$user_id = $_SESSION['user_id'] ?? '';

if (!$task_id || !$user_id) {
    exit('不正なリクエストです');
}

$stmt = $pdo->prepare("DELETE FROM todos WHERE id = ? AND user_id = ?");
$stmt->execute([$task_id, $user_id]);


header("Location: index.php");
exit;
