<?php
session_start();
require_once 'connectDB.php';
$pdo = connectDB_local();

if (isset($_GET['search'])) {
    $keyword = $_GET['keyword'];
    $status = $_GET['status'];
    $priority = $_GET['priority'];

    $query = "SELECT * FROM todos WHERE task LIKE :keyword";
    $params = [':keyword' => "%$keyword%"];

    if ($status != "-1") {
        $query .= " AND status = :status";
        $params[':status'] = $status;
    }

    if ($priority != -1) {
        $query .= " AND priority = :priority";
        $params[':priority'] = $priority;
    }

    $stmt = $pdo->prepare($query);
    $success = $stmt->execute($params);

    if (!$success) {
        $_SESSION['message'] = '検索に失敗しました。';
        header('Location: index.php');
        exit;
    }

    $result = $stmt;

} else {
    $result = $pdo->query('SELECT * FROM todos');
}
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
        <form action="index.php" method="get">
            <input type="text" name="keyword" placeholder="キーワード">

            <select name="status" required>
                <option value="-1"  selected>全て</option>
                <option value="todo">未完了</option>
                <option value="done">完了</option>

            </select>

            <select name="priority" required>
                <option value="-1"  selected>優先度(全て)</option>
                <option value="0">低</option>
                <option value="1">中</option>
                <option value="2">高</option>
            </select>
            <button type="submit" name="search"> 適用</button>
        </form>
    </div><br>

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
                    <a href='editForm_task.php?id={$row['id']}'>編集</a>
                    <a href='delete_task.php?id={$row['id']}'>削除</a>
                </td>
              </tr>";
    }
    ?>

    </table>

</body>
</html>