<?php
session_start();
require 'config.php'; 
require 'model/UserModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    $userModel = new UserModel($pdo);
    $user= $userModel->getUserByUsername($username);

    if (!$user) {
        $_SESSION['error'] = "Tên đăng nhập không tồn tại!";
        header("Location: changePassword.php");
        exit();
    }

    if (!password_verify($current_password, $user->getter('password'))) {
        $_SESSION['error'] = "Mật khẩu hiện tại không đúng!";
        header("Location: changePassword.php");
        exit();
    }

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $updateStmt = $pdo->prepare("UPDATE users SET password = :password WHERE username = :username");
    $updateStmt->execute([
        'password' => $hashed_password,
        'username' => $username
    ]);

    $_SESSION['success'] = "Mật khẩu đã được thay đổi thành công!";
    header("Location: changePassword.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/auth.css">
    <script src="validation.js" defer></script>
</head>

<body>
    <header>

        <nav>
            <a href="dashboard.php">Home</a> |
            <a href="index.php" >Đăng nhập</a> |
            <a href="register.php">Đăng ký</a>
        </nav>
    </header>
    <div class="container">
        <h2>Thay Đổi Mật Khẩu</h2>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p style='color:red; text-align:left;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo "<p style='color:green; text-align:left;'>" . $_SESSION['success'] . "</p>";
            unset($_SESSION['success']);
        }
        ?>
      
        <form method="POST" action="changePassword.php" onsubmit="return validateChangePassword()">

            <label>Username</label>
            <input type="text" name="username"  required>
            <p class="error" id="usernameError"></p>

            <label>Mật khẩu:</label>
            <input type="password" name="current_password" required>

            <label>Mật khẩu mới</label>
            <input type="password" name="new_password" id="password" placeholder="Từ 3 đến 9 kí tự và có kí tự in HOA" required>
            <p class="error" id="passwordError"></p>

            <label>Nhập lại mật khẩu mới</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <p class="error" id="confirmPasswordError"></p><br>
            <div class="button-container" style="display: flex; justify-content: center; align-items: center;">
                <button type="submit">Đổi mật khẩu</button>
            </div>

        </form>
    </div>
    <footer>
        PHP Training @3/2025
    </footer>
</body>

</html>