<?php

class UserModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getUsers($limit, $offset)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users ORDER BY username ASC LIMIT ? OFFSET ?");
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getTotalUsers()
    {
        return $this->pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

    public function getUserByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function setRememberToken($token, $user)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET remember_token = :token WHERE id = :id");
        return $stmt->execute(['token' => $token, 'id' => $user['id']]);
    }

    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id)
    {
        $deleteStmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $deleteStmt->execute([':id' => $id]);
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($username, $email, $description, $id)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET username = :username, email = :email, description = :description WHERE id = :id");
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':description' => $description,
            ':id' => $id
        ]);
    }

    public function createUser($username, $hashed_password, $email)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password, email, description, role) VALUES (:username, :password, :email, NULL,  'member')");
        $stmt->execute([
            ':username' => $username,
            ':password' => $hashed_password,
            ':email' => $email,

        ]);
    }
}
