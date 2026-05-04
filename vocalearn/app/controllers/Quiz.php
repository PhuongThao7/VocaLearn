<?php
class Quiz extends Controller {
    private $db;
    private $flashcardModel;
    
    public function __construct(){
        if(!isset($_SESSION['user_id'])){
            header('location: ' . URLROOT . '/auth/login');
        }
        $this->quizModel = $this->model('QuizModel');
        $this->flashcardModel = $this->model('FlashcardModel');
        $this->db = new Database(); 
    }

    // 1. Màn hình danh sách bài Quiz
    public function index(){
        $quizzes = $this->quizModel->getAllQuizzes(); 
        
        $data = [
            'quizzes' => $quizzes
        ];
        $this->view('quiz/topics', $data);
    }

    // 2. Màn hình làm bài Quiz (Lấy dữ liệu tĩnh)
    public function play($quizId = 1){
        // 1. Lấy thông tin chi tiết Quiz từ DB (Từ bảng quizzes)
        $this->db->query('SELECT * FROM quizzes WHERE id = :id');
        $this->db->bind(':id', $quizId);
        $quizInfo = $this->db->single();
        
        // --- LOGIC FIX LỖI LẶP TẠI ĐÂY ---
        $quizTitle = 'Bài Quiz ' . $quizId; 
        
        if($quizInfo) {
            $fullTitle = $quizInfo->title; // Ví dụ: "Quiz 1: School & Leisure"
            
            // Tìm và loại bỏ phần "Quiz [Số]" ở đầu chuỗi (nếu có)
            if (strpos($fullTitle, ':') !== false) {
                // Tách chuỗi từ sau dấu hai chấm và trim()
                $shortTitle = trim(substr($fullTitle, strpos($fullTitle, ':') + 1));
            } else {
                $shortTitle = $fullTitle; // Giữ nguyên nếu không có dấu hai chấm
            }

            // Nối chuỗi đã chuẩn hóa (Kết quả mong muốn: "Bài Quiz 1: School & Leisure")
            $quizTitle = 'Bài Quiz ' . $quizId . ': ' . $shortTitle;
        }
        
        // 2. Lấy câu hỏi tĩnh từ bảng quiz_questions
        $questions = $this->quizModel->getQuizBySetId($quizId);

        $data = [
            'questions' => $questions,
            'quiz_id' => $quizId,
            'quiz_title' => $quizTitle // Dùng tiêu đề đã chuẩn hóa
        ];

        $this->view('quiz/play', $data);
    }
}