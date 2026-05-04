<?php
class Auth extends Controller {
    public function __construct(){
        $this->userModel = $this->model('UserModel');
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $loggedInUser = $this->userModel->login($username, $password);

            if($loggedInUser){
                $this->createUserSession($loggedInUser);
            } else {
                $data = ['error' => 'Sai tên đăng nhập hoặc mật khẩu'];
                $this->view('auth/login', $data);
            }

        } else {
            $this->view('auth/login');
        }
    }

    public function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = [
                'fullname' => trim($_POST['fullname']),
                'username' => trim($_POST['username']),
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT) // ✔ MÃ HÓA
            ];

            if($this->userModel->register($data)){
                header('location: ' . URLROOT . '/auth/login');
            } else {
                $data['error'] = 'Tên đăng nhập đã tồn tại!';
                $this->view('auth/register', $data);
            }
        } else {
            $this->view('auth/register');
        }
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->fullname;
        $_SESSION['user_role'] = $user->role;
        header('location: ' . URLROOT . '/home');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        header('location: ' . URLROOT . '/auth/login');
    }
}
