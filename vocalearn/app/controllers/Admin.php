<?php
class Admin extends Controller {
    public function __construct(){
        if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin'){
            header('location: ' . URLROOT . '/home');
        }
        $this->userModel = $this->model('UserModel');
        $this->flashcardModel = $this->model('FlashcardModel');
        $this->quizModel = $this->model('QuizModel');
    }

    public function index(){
        $data = [
            'users' => $this->userModel->getUsers(),
            'topics' => $this->flashcardModel->getTopics(),
            'recent_flashcards' => $this->flashcardModel->getFlashcards() 
        ];
        $this->view('admin/dashboard', $data);
    }

    public function deleteUser($id){
        if($this->userModel->deleteUser($id)){
            header('location: ' . URLROOT . '/admin');
        }
    }

    public function deleteFlashcard($id){
        if($this->flashcardModel->deleteFlashcard($id)){
            header('location: ' . URLROOT . '/admin');
        }
    }

    // Cập nhật ảnh 
    public function updateFlashcardImage(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id = $_POST['card_id'];
            $image = trim($_POST['image_url']);
            if($this->flashcardModel->updateImageOnly($id, $image)){
                header('location: ' . URLROOT . '/admin');
            }
        }
    }

    public function addFlashcard(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $topic = !empty($_POST['new_topic']) ? trim($_POST['new_topic']) : $_POST['topic'];
            $data = [
                'topic' => $topic,
                'word' => trim($_POST['word']),
                'meaning' => trim($_POST['meaning']),
                'pronunciation' => trim($_POST['pronunciation']),
                'image' => trim($_POST['image']),
                'example' => trim($_POST['example'])
            ];
            if($this->flashcardModel->addFlashcard($data)){
                header('location: ' . URLROOT . '/admin');
            }
        }
    }

    public function addQuiz(){
    
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = [
                'quiz_id' => $_POST['quiz_id'],
                'question' => trim($_POST['question']),
                'option_a' => trim($_POST['option_a']),
                'option_b' => trim($_POST['option_b']),
                'option_c' => trim($_POST['option_c']),
                'option_d' => trim($_POST['option_d']),
                'correct_option' => $_POST['correct_option']
            ];
            if($this->quizModel->addQuiz($data)){
                header('location: ' . URLROOT . '/admin');
            }
        }
    }
}