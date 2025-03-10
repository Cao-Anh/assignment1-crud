<?php
session_start();
require_once '../config.php';
require_once '../functions.php';
require_once '../model/UserModel.php';

rememberToken();
isAuthenticated();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$userModel = new UserModel($pdo);
$users = $userModel->getUsers($limit, $offset);
$totalUsers = $userModel->getTotalUsers();
$totalPages = ceil($totalUsers / $limit);

$successMessage = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : null;
$errorMessage = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : null;

require '../view/user_list.php';
?>
