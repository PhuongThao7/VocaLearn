<?php
class FlashcardModel {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // Lấy danh sách flashcard theo topic slug
    public function getFlashcards($topicSlug = null){
        if($topicSlug){
            // 1. Lấy topic id theo slug
            $this->db->query("SELECT id FROM topics WHERE slug = :slug");
            $this->db->bind(':slug', $topicSlug);
            $topic = $this->db->single();

            if(!$topic){
                return [];
            }

            // 2. Lấy flashcards theo id
            $this->db->query("SELECT * FROM flashcards WHERE topic_id = :id ORDER BY id DESC");
            $this->db->bind(':id', $topic->id);
        } 
        else {
            $this->db->query("SELECT * FROM flashcards ORDER BY id DESC");
        }

        return $this->db->resultSet();
    }

    // Lấy danh sách chủ đề + số lượng từ vựng
    public function getTopics(){
        $this->db->query("
            SELECT t.id, t.name, t.slug, t.image,
                   COUNT(f.id) AS word_count
            FROM topics t
            LEFT JOIN flashcards f ON f.topic_id = t.id
            GROUP BY t.id, t.name, t.slug, t.image
        ");
        return $this->db->resultSet();
    }

    // Thêm flashcard
    public function addFlashcard($data){
        $this->db->query("
            INSERT INTO flashcards (topic_id, word, meaning, pronounce, img, example)
            VALUES (:topic, :word, :meaning, :pronunciation, :image, :example)
        ");

        $this->db->bind(':topic', $data['topic']); // Lưu id
        $this->db->bind(':word', $data['word']);
        $this->db->bind(':meaning', $data['meaning']);
        $this->db->bind(':pronunciation', $data['pronunciation']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':example', $data['example']);

        return $this->db->execute();
    }

    public function updateImageOnly($id, $image){
        $this->db->query("UPDATE flashcards SET img = :image WHERE id = :id");
        $this->db->bind(':image', $image);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function deleteFlashcard($id){
        $this->db->query("DELETE FROM flashcards WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
