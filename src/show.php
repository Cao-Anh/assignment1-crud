<?php
include 'config.php';
include 'functions.php';
require_once 'model/UserModel.php';


rememberToken();
isAuthenticated();

if (isset($_GET['id'])) {
    $encoded_id = $_GET['id'];


    $user_id = base64_decode($encoded_id);

    $userModel = new UserModel($pdo);
    $user = $userModel->getUserById($user_id);

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
                <td><?= htmlspecialchars($user->getter('username')) ?></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><?= htmlspecialchars($user->getter('email')) ?></td>
            </tr>
            <tr>
                <th>Mô tả:</th>
                <td><?= htmlspecialchars($user->getter('description')??'') ?></td>
            </tr>
        </table>
        <?php if (isAuthorized($user)): ?>
            <a href="edit.php?id=<?= base64_encode($user->getter('id')) ?>">Chỉnh sửa</a>
        <?php endif; ?>

    </div>

</body>
<footer>
        PHP Training @10/2023
    </footer>
</html>