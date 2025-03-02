<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_unset(); 
session_destroy(); 
setcookie('remember_token', '', time() - 3600, "/");

header("Location: index.php"); 
exit();