<?php
require_once "connectDB.php";
$pdo = connectDB_local(); 


$task_id = $_POST['task_id'] ?? '';
$content = $_POST['update_content'] ?? '';
$time_limit = $_POST['update_time_limit'] ?? '';
$priority = $_POST['priority'] ?? '';
$status = $_POST['status'] ?? '';


if ($task_id === '' || trim($content) === '' || $time_limit === '' || $priority === '' || $status === '') {
    exit('すべての項目を入力してください。');
}


$sql = "UPDATE tasks SET content = ?, time_limit = ?, priority = ?, status = ? WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$content, $time_limit, $priority, $status, $task_id]);

// 完了後リダイレクト
header("Location: index.php");
exit;
