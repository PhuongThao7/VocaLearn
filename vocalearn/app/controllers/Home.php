<?php
class Home extends Controller {
    public function __construct(){
        // Có thể check login ở đây nếu muốn
    }

    public function index(){
        $data = [
            'title' => 'Chào mừng đến với VocaLearn',
        ];
        $this->view('home/index', $data);
    }

    // --- THÊM HÀM MỚI NÀY ---
    public function starter(){
        // Gọi view mới riêng biệt cho cấp độ Starter
        $this->view('home/starter');
    }
}