<?php
session_start();
require_once 'connectDB.php';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="header">
        <h1>ToDOリスト</h1>
        <span>
            <?= '大地さん' ?>
            <a href="logout.php">ログアウト</a>
        </span>
    </div>

    <div class="message">
        <?php if (isset($_SESSION['message'])): ?>
            <p><?= $_SESSION['message'] ?></p>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
    </div>

    <div class="addTask">
        <h2>タスク追加</h2>
        <form action="add_task.php" method="post">
            <input type="text" name="task_name" placeholder="タスク内容" required>
            <input type="date" name="due_date" required>
            <select name="priority" required>
                <option value="0" disabled selected>優先度(低)</option>
                <option value="1">中</option>
                <option value="2">高</option>
            </select>
            <button type="submit" name="add_task">追加</button>
        </form>
    </div>
</body>
</html>