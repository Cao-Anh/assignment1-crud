<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once 'model/UserModel.php';

session_start();
require 'config.php';

if (isset($_SESSION['error'])) {
    echo "<script>alert('" . htmlspecialchars($_SESSION['error']) . "');</script>";
    unset($_SESSION['error']); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Check if email exists
    $userModel = new UserModel($pdo);
    $user= $userModel->getUserByEmail($email);

    if ($user) {
        // Generate temporary password (8 characters)
        $temp_password = bin2hex(random_bytes(4));
        $hashed_temp_password = password_hash($temp_password, PASSWORD_DEFAULT);

        // Update the database with the new hashed password
        $updateStmt = $pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
        $updateStmt->execute(['password' => $hashed_temp_password, 'email' => $email]);

        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Use Gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'dangcaoanh1998@gmail.com'; // Replace with your Gmail
            $mail->Password = 'yavj wacb yaxg oajx'; // Use App Password, NOT Gmail password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->SMTPDebug = 2;
            $mail->Debugoutput = 'html';

            // Email Content
            $mail->setFrom('dangcaoanh1998@gmail.com', 'assignment1-crud');
            $mail->addAddress($email);
            $mail->Subject = "Password Reset Request";
            $mail->Body = "Your temporary password is: " . $temp_password . "\nPlease log in and change your password.";

            $mail->send();
            $_SESSION['success'] = "Mật khẩu đã được gửi, kiểm tra email của bạn.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Không thể gửi email: " . $mail->ErrorInfo;
        }
    } else {
        $_SESSION['error'] = "Không tìm thấy địa chỉ email!";
        header("Location: forgotPassword.php");
        exit();
    }
    

    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/auth.css">
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
        <h2>Quên Mật khẩu</h2>
        <form method="POST">
            <p>Hệ thống sẽ gửi mật khẩu mới tới email của bạn</p>
            <label for="email">Nhập email:</label>
            <input type="email" name="email" required>
            <div class="button-container" style="display: flex; justify-content: center; align-items: center;">
                <button style="margin: 10px; width: auto;">Gửi yêu cầu</button>
            </div>

        </form>
    </div>
    <footer>
        PHP Training @10/2023
    </footer>
</body>

</html>