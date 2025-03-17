<?php
require_once 'BaseModel.php';

class UserModel extends BaseModel
{
    public function getUsers($limit, $offset)
    {
        return $this->select("SELECT * FROM users ORDER BY username ASC LIMIT ? OFFSET ?", [$limit, $offset]);
    }

    public function getTotalUsers()
    {
        return $this->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

    public function getUserByUsername($username)
    {
        return $this->selectOne("SELECT * FROM users WHERE username = :username", ['username' => $username]);
    }

    public function setRememberToken($token, $user)
    {
        return $this->update("UPDATE users SET remember_token = :token WHERE id = :id", ['token' => $token, 'id' => $user['id']]);
    }

    public function getUserById($id)
    {
        return $this->selectOne("SELECT * FROM users WHERE id = :id", ['id' => $id]);
    }

    public function deleteUser($id)
    {
        return $this->delete("DELETE FROM users WHERE id = :id", ['id' => $id]);
    }

    public function getUserByEmail($email)
    {
        return $this->selectOne("SELECT * FROM users WHERE email = :email", ['email' => $email]);
    }

    public function updateUser($username, $email, $description, $id)
    {
        return $this->update(
            "UPDATE users SET username = :username, email = :email, description = :description WHERE id = :id",
            ['username' => $username, 'email' => $email, 'description' => $description, 'id' => $id]
        );
    }

    public function createUser($username, $hashed_password, $email)
    {
        return $this->insert(
            "INSERT INTO users (username, password, email, description, role) VALUES (:username, :password, :email, NULL, 'member')",
            ['username' => $username, 'password' => $hashed_password, 'email' => $email]
        );
    }
}
