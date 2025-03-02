<?php
session_start();
include 'config.php';
require 'functions.php';

rememberToken();
isAuthenticated();
// Check and fetch user id
if (isset($_GET['id'])) {
    $encoded_id = $_GET['id'];


    $user_id = base64_decode($encoded_id);


    if (!is_numeric($user_id)) {
        die("Invalid request1!");
    }

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

if (!isAuthorized($user)) {
    header("Location: dashboard.php?error=Bạn không có quyền chỉnh sửa người dùng này!");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);
    $description = trim($_POST['description']);



    // Validate unique username
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    if ($stmt->fetch() && $user['username'] != $username) {
        header("Location: edit.php?id=" . $encoded_id . "&errorUsername=Tên đăng nhập đã tồn tại!");
        exit;
    }



    // Validate unique email
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch() && $user['email'] != $email) {
        header("Location: edit.php?id=" . $encoded_id . "&errorEmail=Email đã tồn tại!");
        exit;
    }
    // Verify password
    if (!password_verify($password, $user['password'])) {
        header("Location: edit.php?id=" . $encoded_id . "&errorPassword=Mật khẩu hiện tại không đúng!");
        exit;
    }

    // Update user info

    $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, description = :description WHERE id = :id");
    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':description' => $description,
        ':id' => $user_id
    ]);

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
        <?php if (!empty($_GET['errorPassword'])) echo "<p class='error'>" . htmlspecialchars($_GET['errorPassword']) . "</p>"; ?>

        <form method="POST" action="edit.php?id=<?= $encoded_id ?>" >
            <label>Username</label>
            <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required>
            <p class="error" id="usernameError"></p>

            <label>Mật khẩu</label>
            <input type="password" name="password" id="password" required>
            <p class="error" id="passwordError"></p>

            <label>Nhập lại mật khẩu</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <p class="error" id="confirmPasswordError"></p>

            <label>Email</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            <p class="error" id="emailError"></p>

            <label>Mô tả (tùy chọn)</label>
            <textarea name="description" id="description"><?= htmlspecialchars($user['description'] ?? '') ?></textarea>
            <!-- <a href="#" id="changePasswordLink">Đổi mật khẩu</a> -->
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