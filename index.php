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
            <?php if (isset($_SESSION['user_name'])): ?>
                <?= $_SESSION['user_name'] ?>さん
            <?php endif ?>
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
                <option value="0" selected>優先度(低)</option>
                <option value="1">中</option>
                <option value="2">高</option>
            </select>
            <button type="submit" name="add_task">追加</button>
        </form>
    </div>
    
    <div class="search">
        <h2>フィルター/検索</h2>
        <form action="search.php" method="post">
            <input type="text" name="keyword" placeholder="キーワード" required>
            <select name="priority" required>
                <option value="-1"  selected>優先度(全て)</option>
                <option value="0">低</option>
                <option value="1">中</option>
                <option value="2">高</option>
            </select>
            <button type="submit" name="search"> 適用</button>
        </form>
    </div>

    <?php
    $pdo = connectDB_local();
    $result = $pdo->query('SELECT * FROM todos');
    ?>

    <table border="1">
        <tr>
            <th>状態</th>
            <th>タスク</th>
            <th>期限</th>
            <th>優先度</th>
            <th>操作</th>
        </tr>

    <?php
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $priority = ['低', '中', '高'][$row['priority']];
        echo "<tr>
                <td>{$row['status']}</td>
                <td>{$row['task']}</td>
                <td>{$row['due_date']}</td>
                <td>{$priority}</td>
                <td>
                    <a href='edit_task.php?id={$row['id']}'>編集</a>
                    <a href='delete_task.php?id={$row['id']}'>削除</a>
                </td>
              </tr>";
    }
    ?>

    </table>

</body>
</html>