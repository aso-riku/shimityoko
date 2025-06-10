<?php
session_start();
require_once 'connectDB.php';

$task_name = $_POST['task_name'] ?? '';
$due_date = $_POST['due_date'] ?? '';
$priority = $_POST['priority'] ?? '';
$date = date('Y-m-d H:i:s');

$pdo = connectDB_local();
$sql = "INSERT INTO todos (user_id, task, due_date, priority, created_at) VALUES (?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id'], $task_name, $due_date, $priority, $date]);

if ($stmt->rowCount() > 0) {
    $_SESSION['message'] = 'タスクが追加されました。';
} else {
    $_SESSION['message'] = 'タスクの追加に失敗しました。';
}

header('Location: index.php');