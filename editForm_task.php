<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク編集画面</title>
</head>
<body>
    <h1>タスク編集</h1>
    <form action="">
        内容:<input type="text" name="update_content" value="仮" required><br>
        期限:<input type="date" name="update_time_limit" required><br>
        優先度:
            <select name="priority" required>
                <option value="0">低</option>
                <option value="1">中</option>
                <option value="2">高</option>
            </select><br>
        状態:
            <select name="status" required>
                <option value="incomplete">未完了</option>
                <option value="complete">完了</option>
            </select><br>
            <button type="submit" name="edit">保存</button><br>
            <a href="index.php">キャンセル</a>
    </form>
    
</body>
</html>