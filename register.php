<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>ユーザー登録</title>
</head>
<body>
    <div class="form-container">
        <h1>ユーザー登録</h1>
        <form action="check.php" method="post">
            ユーザー名:<input type="text" name="new_userName"><br>
            パスワード：<input type="password" name="new_password"><br>
            <button type="submit" name="register">登録</button>
        </form>
        <a href="login.php">ログインはこちら</a>
    </div> </body>
</html>