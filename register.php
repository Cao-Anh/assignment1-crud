<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = trim($_POST['email']);



    // Validate unique username
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    if ($stmt->fetch()) {
        $_SESSION['error']= 'Tên đăng nhập đã tồn tại, vui lòng chọn tên khác!';
        header("Location: register.php");
        exit;
    }



    // Validate unique email
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        $_SESSION['error']= 'Email đã tồn tại, vui lòng nhập email khác!';
        header("Location: register.php");
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into database
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, description, role) VALUES (:username, :password, :email, NULL,  'member')");
    $stmt->execute([
        ':username' => $username,
        ':password' => $hashed_password,
        ':email' => $email,

    ]);
    $_SESSION['success']= 'Đăng ký thành công!';
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="css/auth.css">
    <script src="validation.js" defer></script>
</head>

<body>
    <header>

        <nav>
            <a href="dashboard.php">Home</a> |
            <a href="index.php">Đăng nhập</a> |
            <a class="active" href="register.php">Đăng ký</a>
        </nav>
    </header>
    <div class="container">
        <h2>Màn hình đăng ký</h2>

        <?php
        if (isset($_SESSION['error'])) {
            echo "<p style='color:red; text-align:left;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
       
        ?>

        <form method="POST" action="register.php" onsubmit="return validateRegister()">
            <label>Username</label>
            <input type="text" name="username" id="username" placeholder="Chỉ từ 3 đến 8 kí tự" required>
            <p class="error" id="usernameError"></p>


            <label>Mật khẩu</label>
            <input type="password" name="password" id="password" placeholder="Từ 3 đến 9 kí tự và có kí tự in HOA" required>
            <p class="error" id="passwordError"></p>

            <label>Nhập lại mật khẩu</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <p class="error" id="confirmPasswordError"></p>

            <label>Email</label>
            <input type="email" name="email" id="email" required>
            <p class="error" id="emailError"></p>

            <div class="button-container">
                <p><a href="index.php">Đã có tài khoản</a></p>
                <button type="submit">Đăng ký</button>
            </div>

        </form>


    </div>
    <footer>
        PHP Training @10/2023
    </footer>
</body>

</html>