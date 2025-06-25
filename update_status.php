<?php
require_once 'connectDB.php';
$pdo = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $status = $_POST['status'] ?? null;

    if ($id !== null && ($status === 'todo' || $status === 'done')) {
        $stmt = $pdo->prepare('UPDATE todos SET status = :status WHERE id = :id');
        $success = $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);

        if ($success) {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM todos WHERE user_id = ?');
            $total = (int)$stmt->execute([$_SESSION['user_id']]) ? $stmt->fetchColumn() : 0;
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM todos WHERE user_id = ? AND status = 'done'");
            $done = (int)$stmt->execute([$_SESSION['user_id']]) ? $stmt->fetchColumn() : 0;
            echo json_encode(['success' => true,
                              'total' => $total,
                              'done' => $done
                            ]);
        } else {
            echo json_encode(['success' => false, 'error' => 'DB update failed']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
    }


} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}    
