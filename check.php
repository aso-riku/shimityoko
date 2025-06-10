<?php
require_once "connectDB.php";

$pdo = connectDB_local();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['register'])) {
        $username = $_POST['new_userName'] ?? '';
        $password = $_POST['new_password'] ?? '';

        if (trim($username) === '' || trim($password) === '') {
            exit('ユーザー名とパスワードは必須です');
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            exit('そのユーザー名はすでに使われています');
        }

        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hash]);

        echo "登録が完了しました。<a href='login.php'>ログイン</a>へ";
        exit;
    }

    if (isset($_POST['login'])) {
        echo "ログインボタンが押されました（処理未実装）。";
        exit;
    }

}
