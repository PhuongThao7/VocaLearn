<?php
class QuizModel {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // --- HÀM ĐÃ ĐƯỢC CHỈNH SỬA ĐỂ ĐẾM TẤT CẢ CÂU HỎI (BỎ LIMIT 5) ---
    public function getAllQuizzes(){
        $this->db->query('SELECT q.id, q.title, q.description, q.topic_group FROM quizzes q ORDER BY q.id ASC');
        $quizzes = $this->db->resultSet();

        foreach($quizzes as $quiz){
            // FIX LỖI ĐẾM: Loại bỏ LIMIT 5 để đếm TẤT CẢ câu hỏi thuộc Quiz đó
            $this->db->query('SELECT COUNT(*) as count FROM quiz_questions WHERE quiz_id = :quiz_id');
            $this->db->bind(':quiz_id', $quiz->id);
            $countResult = $this->db->single();
            $quiz->count = $countResult->count;
        }

        return $quizzes;
    }
    
    // Hàm này lấy TẤT CẢ câu hỏi cho trang làm bài 
    public function getQuizBySetId($quizId){
        $this->db->query('SELECT * FROM quiz_questions WHERE quiz_id = :quiz_id ORDER BY id ASC');
        $this->db->bind(':quiz_id', $quizId);
        return $this->db->resultSet();
    }

    // Thêm câu hỏi mới vào Database
    public function addQuiz($data){
        $this->db->query('INSERT INTO quiz_questions (quiz_id, question, option_a, option_b, option_c, option_d, correct_option) VALUES(:quiz_id, :question, :option_a, :option_b, :option_c, :option_d, :correct_option)');
        $this->db->bind(':quiz_id', $data['quiz_id']);
        $this->db->bind(':question', $data['question']);
        $this->db->bind(':option_a', $data['option_a']);
        $this->db->bind(':option_b', $data['option_b']);
        $this->db->bind(':option_c', $data['option_c']);
        $this->db->bind(':option_d', $data['option_d']);
        $this->db->bind(':correct_option', $data['correct_option']);
        return $this->db->execute();
    }
}