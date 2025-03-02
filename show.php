<?php
include 'config.php';
include 'functions.php';

rememberToken();
isAuthenticated();

if (isset($_GET['id'])) {
    $encoded_id = $_GET['id'];


    $user_id = base64_decode($encoded_id);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([':id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found!";
        exit;
    }
} else {
    echo "Invalid request2!";
    exit;
}
if (isset($_GET['success'])) {
    $message = $_GET['success'];
    echo "<script>alert('$message');</script>";
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Người Dùng</title>
    <link rel="stylesheet" href="css/style1.css">
</head>

<body>
<header >

<nav>
    <a href="dashboard.php">Home</a> |
    <a href="logout.php">Đăng xuất</a>
</nav>

</header>
    <div class="container">
        <h2>Thông Tin Người Dùng</h2>

        <table>
            <tr>
                <th>Username:</th>
                <td><?= htmlspecialchars($user['username']) ?></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><?= htmlspecialchars($user['email']) ?></td>
            </tr>
            <tr>
                <th>Mô tả:</th>
                <td><?= htmlspecialchars($user['description']) ?></td>
            </tr>
        </table>
        <?php if (isAuthorized($user)): ?>
            <a href="edit.php?id=<?= base64_encode($user['id']) ?>">Chỉnh sửa</a>
        <?php endif; ?>

    </div>

</body>
<footer>
        PHP Training @10/2023
    </footer>
</html>