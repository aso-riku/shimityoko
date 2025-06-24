<?php
require_once 'connectDB.php';
$pdo = connectDB_local();

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
            $total = (int)$pdo->query('SELECT COUNT(*) FROM todos')->fetchColumn();
            $done = (int)$pdo->query("SELECT COUNT(*) FROM todos WHERE status = 'done'")->fetchColumn();
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
