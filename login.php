<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>ログイン</h1>
    <form action="check.php" method="post" name="action">
        ユーザ名：<input type="text" name="user_name"><br>
        パスワード：<input type="password" name="password"><br>
        <button type="submit" name="action" value="login">ログイン</button><br><br>
    </form>
    <a href="register.php">新規登録</a>
</body>
</html>
