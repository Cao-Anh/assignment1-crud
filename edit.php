<?php
session_start();
include 'config.php';
require 'functions.php';
require_once 'model/UserModel.php';


rememberToken();
isAuthenticated();


if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check and fetch user id
if (isset($_GET['id'])) {
    $encoded_id = $_GET['id'];
    $user_id = base64_decode($encoded_id);

    if (!is_numeric($user_id)) {
        die("Invalid request1!");
    }

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

if (!isAuthorized($user)) {
    header("Location: dashboard.php?error=Bạn không có quyền chỉnh sửa người dùng này!");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRF token validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token không hợp lệ!");
    }

    // Generate a new CSRF token after validation
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);
    $description = trim($_POST['description']);

    // Validate unique username
    $isUsernameExist= $userModel->getUserByUsername($username);
    if ($isUsernameExist && $user['username'] != $username) {
        header("Location: edit.php?id=" . $encoded_id . "&errorUsername=Tên đăng nhập đã tồn tại!");
        exit;
    }

    // Validate unique email
    $isEmailExist= $userModel->getUserByEmail($email);   
    if ($isEmailExist && $user['email'] != $email) {
        header("Location: edit.php?id=" . $encoded_id . "&errorEmail=Email đã tồn tại!");
        exit;
    }

    
    // Update user info
    $userModel->updateUser($username, $email, $description, $user_id);

    // Update session if editing self
    if ($_SESSION['user']['id'] == $user_id) {
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['description'] = $description;
    }

    header("Location: show.php?id=" . $encoded_id . "&success=Cập nhật thành công!");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa tài khoản</title>
    <link rel="stylesheet" href="css/auth.css">
    <script src="validation.js" defer></script>
</head>

<body>
    <header>

        <nav>
            <a href="dashboard.php">Home</a> |
            <a href="logout.php">Đăng xuất</a>
        </nav>

    </header>
    <div class="container">
        <h2>Chỉnh sửa thông tin</h2>
        <?php if (!empty($_GET['errorUsername'])) echo "<p class='error'>" . htmlspecialchars($_GET['errorUsername']) . "</p>"; ?>
        <?php if (!empty($_GET['errorEmail'])) echo "<p class='error'>" . htmlspecialchars($_GET['errorEmail']) . "</p>"; ?>

        <form method="POST" action="edit.php?id=<?= $encoded_id ?>" >
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <label>Username</label>
            <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required>
            <p class="error" id="usernameError"></p>

            <label>Email</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            <p class="error" id="emailError"></p>

            <label>Mô tả (tùy chọn)</label>
            <textarea name="description" id="description"><?= htmlspecialchars($user['description'] ?? '') ?></textarea>

            <div class="button-container" style="margin-top: 10px;">
                <button onclick="window.history.back();">Quay lại</button>
                <button type="submit">Cập nhật</button>
            </div>
        </form>




    </div>
    <footer>
        PHP Training @10/2023
    </footer>
</body>


</html>