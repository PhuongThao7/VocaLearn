<?php
class UserModel {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // Đăng nhập CÓ mã hóa
    public function login($username, $password){
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        if($row){
            // Mật khẩu đã HASH -> dùng password_verify
            if(password_verify($password, $row->password)){
                return $row; // đúng
            } else {
                return false; // sai mật khẩu
            }
        } else {
            return false; // không có user
        }
    }

    // Đăng ký CÓ mã hóa
    public function register($data){
        $this->db->query('INSERT INTO users (fullname, username, password) VALUES(:name, :user, :pass)');
        $this->db->bind(':name', $data['fullname']);
        $this->db->bind(':user', $data['username']);
        $this->db->bind(':pass', $data['password']); // ← password đã hash tại Auth.php

        try {
            return $this->db->execute();
        } 
        catch (PDOException $e) {
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062) {
                return false; // username trùng
            }
            throw $e;
        }
    }

    public function getUsers(){
        $this->db->query('SELECT * FROM users');
        return $this->db->resultSet();
    }

    public function deleteUser($id){
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}