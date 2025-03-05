<?php
require 'config.php';
require 'functions.php';
rememberToken();
isAuthenticated();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token không hợp lệ!");
    }

    if (isset($_POST['id'])) {
        $encoded_id = $_POST['id'];
        $user_id = base64_decode($encoded_id);

        // Check if user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            header("Location: dashboard.php?error= Không tìm thấy người dùng!");
            exit;
        }

        if (!isAuthorized($user)) {
            header("Location: dashboard.php?error=Bạn không có quyền xóa người dùng này!");
            exit;
        }

        // Delete the user
        $deleteStmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        if ($deleteStmt->execute([':id' => $user_id])) {
            header("Location: dashboard.php?success=Xóa người dùng thành công!");
            exit;
        } else {
            header("Location: dashboard.php?error=Xóa người dùng thất bại!");
            exit;
        }
    } else {
        echo "Invalid request!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}

?>