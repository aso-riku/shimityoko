<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>ログイン</title>
</head>
<body>
    <div class="form-container">
        <h1>ログイン</h1>
        <form action="check.php" method="post">
            ユーザ名：<input type="text" name="user_name"><br>
            パスワード：<input type="password" name="password"><br>
            <button type="submit" name="login">ログイン</button>
        </form>
        <a href="register.php">新規登録</a>
    </div> </body>
</html>