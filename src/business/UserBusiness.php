<?php

class UserBusiness
{
    public int $id;
    public string $username;
    public string $email;
    public string $password;
    public ?string $description;
    public string $role;
    public ?string $remember_token;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->description = $data['description'] ?? null;
        $this->role = $data['role'];
        $this->remember_token = $data['remember_token'] ?? null;
    }
    public function getter ($param){
        return $this->$param;
    }
}
