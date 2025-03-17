<?php
require_once 'BaseModel.php';
require_once './business/UserBusiness.php';

class UserModel extends BaseModel
{
    public function getUsers(int $limit, int $offset): array
    {
        $data = $this->select("SELECT * FROM users ORDER BY username ASC LIMIT ? OFFSET ?", [$limit, $offset]);
        return array_map(fn($user) => new UserBusiness($user), $data);
    }

    public function getTotalUsers(): int
    {
        return (int) $this->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

    public function getUserByUsername(string $username): ?UserBusiness
    {
        $data = $this->selectOne("SELECT * FROM users WHERE username = :username", ['username' => $username]);
        return $data ? new UserBusiness($data) : null;
    }

    public function setRememberToken(string $token, UserBusiness $user): bool
    {
        return $this->update("UPDATE users SET remember_token = :token WHERE id = :id", ['token' => $token, 'id' => $user->id]);
    }

    public function getUserById(int $id): ?UserBusiness
    {
        $data = $this->selectOne("SELECT * FROM users WHERE id = :id", ['id' => $id]);
        return $data ? new UserBusiness($data) : null;
    }

    public function deleteUser(int $id): bool
    {
        return $this->delete("DELETE FROM users WHERE id = :id", ['id' => $id]);
    }

    public function getUserByEmail(string $email): ?UserBusiness
    {
        $data = $this->selectOne("SELECT * FROM users WHERE email = :email", ['email' => $email]);
        return $data ? new UserBusiness($data) : null;
    }

    public function updateUser(string $username, string $email, ?string $description, int $id): bool
    {
        return $this->update(
            "UPDATE users SET username = :username, email = :email, description = :description WHERE id = :id",
            ['username' => $username, 'email' => $email, 'description' => $description, 'id' => $id]
        );
    }

    public function createUser(string $username, string $hashed_password, string $email): bool
    {
        return $this->insert(
            "INSERT INTO users (username, password, email, description, role) VALUES (:username, :password, :email, NULL, 'member')",
            ['username' => $username, 'password' => $hashed_password, 'email' => $email]
        );
    }
}
