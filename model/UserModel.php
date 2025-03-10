<?php
require_once '../config.php';

class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getUsers($limit, $offset) {
        $stmt = $this->pdo->prepare("SELECT * FROM users ORDER BY username ASC LIMIT ? OFFSET ?");
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll();
    }

    public function getTotalUsers() {
        return $this->pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }
}
?>
