<?php
session_start();
require_once "connectDB.php";

$pdo = connectDB_local();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['register'])) {
        $username = $_POST['new_userName'] ?? '';
        $password = $_POST['new_password'] ?? '';

        if (trim($username) === '' || trim($password) === '') {
            exit('ユーザー名とパスワードは必須です');
        }

        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            exit('そのユーザー名はすでに使われています');
        }

        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);

        echo "登録が完了しました。<a href='login.php'>ログイン</a>へ";
        exit;
    }

    if (isset($_POST['login'])) {
        echo "ログインボタンが押されました（処理未実装）。";
        $username = $_POST['user_name'];
        $password = $_POST['password'];

        $sql='SELECT * FROM users WHERE username = ? AND password = ?';
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$username, $password]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $pdo->lastInsertId();

        if(!empty($result)){
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $result['username'];
            header('Location: index.php');
            exit;
        }else{
            header('Location: login.php');
            exit;
        }
        exit;
    }

}
