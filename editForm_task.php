<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    exit('ログインしてください。');
}

require_once 'connectDB.php';
$pdo = connectDB_local();

$task_id = $_GET['id'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM todos WHERE id = ? AND user_id = ?");
$stmt->execute([$task_id, $_SESSION['user_id']]);
$task = $stmt->fetch();
?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/edit.css">
    <title>タスク編集画面</title>
</head>
<body>
    <h1>タスク編集</h1>
    <form action="editExe_task.php" method="post">
    <input type="hidden" name="task_id" value="<?= htmlspecialchars($task_id) ?>">
        内容:<input type="text" name="update_content" value="<?= htmlspecialchars($task['task']) ?>" required><br>
        期限:<input type="date" name="update_time_limit" value="<?=htmlspecialchars($task['due_date']) ?>" required><br>
        優先度:
            <select name="priority" required>
                <option value="0" <?= $task['priority'] == 0 ? 'selected' : '' ?>>低</option>
                <option value="1" <?= $task['priority'] == 1 ? 'selected' : '' ?>>中</option>
                <option value="2" <?= $task['priority'] == 2 ? 'selected' : '' ?>>高</option>
            </select><br>
        状態:
            <select name="status" required>
                <option value="todo" <?= $task['status'] == 'todo' ? 'selected' : '' ?>>未完了</option>
                <option value="done" <?= $task['status'] == 'done' ? 'selected' : '' ?>>完了</option>
            </select><br>
            <button type="submit" name="edit">保存</button><br>
            <a href="index.php">キャンセル</a>
    </form>
    

</body>
</html>