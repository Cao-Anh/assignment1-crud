<?php

session_start();
require_once 'config.php';
require_once 'functions.php';
require_once 'model/UserModel.php';

rememberToken();
isAuthenticated();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$userModel = new UserModel($pdo);
$users = $userModel->getUsers($limit, $offset);
$totalUsers = $userModel->getTotalUsers();
$totalPages = ceil($totalUsers / $limit);

if (isset($_GET['error'])) {
    echo "<script>alert('" . htmlspecialchars($_GET['error']) . "');</script>";
    unset($_GET['error']);
}
if (isset($_GET['success'])) {
    echo "<script>alert('" . htmlspecialchars($_GET['success']) . "');</script>";
    unset($_GET['success']);
}



?>
<!DOCTYPE html>
<html>

<head>
    <title>User List</title>
    <link rel="stylesheet" href="css/style1.css">
</head>

<body>
    <header>

        <nav>
            <a class="active" href="#">Home</a> |
            <a href="logout.php">Đăng xuất</a>
        </nav>

    </header>
    <div class="container">
        <h1>Danh sách người dùng</h1>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Mô tả</th>
                    <th>Lệnh</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['description'] ?? '')?></td>
                        <td>
                            <?php $encoded_id = base64_encode($user['id']); ?>
                            <a href="show.php?id=<?= $encoded_id ?>">Xem</a>
                            <?php if (isAuthorized($user)): ?>
                                <a href="edit.php?id=<?= $encoded_id ?>">Sửa</a>
                            <?php endif; ?>
                            <?php if (isAuthorized($user)): ?>
                                <form action="delete.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="id" value="<?= $encoded_id; ?>">
                                    <button style="all: unset;color: blue;text-decoration: underline;cursor: pointer;display: inline;"
                                     type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" <?= $i === $page ? 'class="active"' : '' ?>><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </div>
    <footer>
        PHP Training @10/2023
    </footer>
</body>

</html>