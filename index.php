<?php
session_start();
require_once 'connectDB.php';
$pdo = connectDB_local();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['search'])) {
    $keyword = $_GET['keyword'];
    $status = $_GET['status'];
    $priority = $_GET['priority'];

    $query = "SELECT * FROM todos WHERE user_id = :user_id AND task LIKE :keyword";
    $params = [':user_id' => $_SESSION['user_id']];
    $params[':keyword'] = "%$keyword%";

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
    $result = $pdo->query('SELECT * FROM todos WHERE user_id = ' . $_SESSION['user_id']);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
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
            $isChecked = $row['status'] === 'done' ? 'checked' : '';
            $rowClass = $row['status'] === 'done' ? 'done-row' : '';
            $taskId = $row['id'];

            echo "<tr data-id='{$taskId}' class='{$rowClass}'>
                    <td><input type='checkbox' class='status-checkbox' data-id='{$taskId}' {$isChecked}></td>
                    <td>{$row['task']}</td>
                    <td>{$row['due_date']}</td>
                    <td>{$priority}</td>
                    <td>
                        <a href='editForm_task.php?id={$row['id']}'>編集</a>
                        <a href='delete_task.php?id={$row['id']}' onclick=\"return confirm('削除しますか？');\">削除</a>
                    </td>
                </tr>";
        }
        ?>
        </table>

        <style>
        /* 行全体に横線を入れる */
        .done-row td {
            text-decoration: line-through;
            color: gray;
        }
        </style>

        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('.status-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const row = this.closest('tr');
                    const taskId = this.dataset.id;
                    const isChecked = this.checked;
                    const newStatus = isChecked ? 'done' : 'todo';

                    if (this.checked) {
                        row.classList.add('done-row');
                    } else {
                        row.classList.remove('done-row');
                    }

                    // クラスの切り替え（見た目用）
                    row.classList.toggle('done-task', isChecked);

                    // サーバーに状態変更を送信
                    fetch('update_status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id=${encodeURIComponent(taskId)}&status=${encodeURIComponent(newStatus)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            alert('更新に失敗しました: ' + (data.error || ''));
                            // チェックを元に戻す
                            this.checked = !isChecked;
                            row.classList.toggle('done-task', !isChecked);
                        }
                    })
                    .catch(error => {
                        alert('通信エラーが発生しました');
                        this.checked = !isChecked;
                        row.classList.toggle('done-task', !isChecked);
                    });
                });
            });
        });
        </script>
</body>
</html>