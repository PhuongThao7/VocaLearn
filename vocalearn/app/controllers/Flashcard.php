<?php
class Flashcard extends Controller {
    public function __construct(){
        if(!isset($_SESSION['user_id'])){
            header('location: ' . URLROOT . '/auth/login');
        }
        $this->flashcardModel = $this->model('FlashcardModel');
    }

    // 1. Trang danh sách chủ đề 
    public function index(){
        $topics = $this->flashcardModel->getTopics();
        
        $data = [
            'topics' => $topics
        ];

        // Gọi view hiển thị danh sách
        $this->view('flashcard/topics', $data);
    }

    // 2. Trang học từ vựng 
    public function learn($topic = null){
        if(!$topic) {
            header('location: ' . URLROOT . '/flashcard'); // Quay về danh sách nếu thiếu topic
        }

        $topicName = urldecode($topic);
        
        $cards = $this->flashcardModel->getFlashcards($topicName);

        $data = [
            'flashcards' => $cards,
            'topic' => $topicName
        ];

        $this->view('flashcard/learn', $data);
    }
}