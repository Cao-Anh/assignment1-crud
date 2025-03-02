<?php
//yavj wacb yaxg oajx google app password

// session_start();
require 'config.php';
require 'functions.php';
rememberToken();
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_SESSION['success'])) {
    echo "<script>alert('" . $_SESSION['success'] . "');</script>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<script>alert('" . $_SESSION['error'] . "');</script>";
    unset($_SESSION['error']);
}

// if (isset($_GET['success'])) {
//     $message = $_GET['success'];
//     echo "<script>alert('$message');</script>";
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user'] = $user;
        if (isset($_POST['remember_token'])) {
            $token = bin2hex(random_bytes(32));
            setcookie('remember_token', $token, time() + (86400 * 30), "/");

            $stmt = $pdo->prepare("UPDATE users SET remember_token = :token WHERE id = :id");
            $stmt->execute(['token' => $token, 'id' => $user['id']]);
        }

        header("Location: dashboard.php");
        exit();
    } else {
        $error="Tài khoản hoặc mật khẩu không đúng, vui lòng đăng nhập lại.";
    }
}
if (isset($_GET['error'])) {
    echo "<script>alert('" . htmlspecialchars($_GET['error']) . "');</script>";
}

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Training </title>
    <link rel="stylesheet" href="css/auth.css"
        </head>

<body>
    <header>

        <nav>
            <a href="dashboard.php">Home</a> |
            <a href="index.php" class="active">Đăng nhập</a> |
            <a href="register.php">Đăng ký</a>
        </nav>
    </header>
    <div class="container">


        <div class="login-box">
            <h2>Màn hình đăng nhập</h2>
            <form method="POST" action="index.php">
                <?php if (!empty($error)): ?>
                    <span class="error"><?php echo $error; ?></span>
                <?php endif; ?>

                <label>Username:</label>
                <input type="text" name="username" required>

                <label>Mật khẩu:</label>
                <input type="password" name="password" required>

                <div class="remember">
                    <input type="checkbox" name="remember_token">
                    <label>Ghi nhớ đăng nhập</label>
                </div>

                <div class="button-container">
                    <a href="changePassword.php" class="forgot">Đổi mật khẩu</a>
                    <a href="forgotPassword.php" class="forgot">Quên mật khẩu</a>
                    <button type="submit">Đăng nhập</button>
                </div>
            </form>
        </div>


    </div>
    <footer>
        PHP Training @10/2023
    </footer>
</body>

</html>