<?php
require 'config.php';
require 'functions.php';
rememberToken();
isAuthenticated();


if (isset($_GET['id'])) {
    $encoded_id = $_GET['id'];
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
        header("Location: dashboard.php?error=Bạn không có quyền chỉnh sửa người dùng này!");
        exit;
    }

    // Delete the user
    $deleteStmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    if ($deleteStmt->execute([':id' => $user_id])) {
        // Redirect with success message
        header("Location: dashboard.php?success= Xóa người dùng thành công!");
        exit;
    } else {
       
        header("Location: dashboard.php?success= Xóa người dùng thất bại!");
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}
?>
