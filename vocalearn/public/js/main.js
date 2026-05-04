// Xử lý Logic Flashcard bên Client

const appDiv = document.getElementById('flashcard-app');
let flashcards = [];
let currentIndex = 0;

if(appDiv) {
    // Lấy dữ liệu từ thuộc tính data-cards trong HTML
    try {
        flashcards = JSON.parse(appDiv.dataset.cards);
        renderCard();
    } catch (e) {
        console.error("Lỗi parse dữ liệu flashcard", e);
    }
}

function renderCard() {
    if(flashcards.length === 0) return;
    const card = flashcards[currentIndex];
    
    // Cập nhật nội dung thẻ
    document.getElementById('card-img').src = card.image;
    document.getElementById('card-word').innerText = card.word;
    document.getElementById('card-meaning').innerText = card.meaning;
    document.getElementById('card-pronun').innerText = `/${card.pronunciation}/`;
    
    // Reset trạng thái lật thẻ về mặt trước
    const container = document.querySelector('.flashcard-container');
    if(container.classList.contains('flipped')) {
        container.classList.remove('flipped');
    }
    
    // Cập nhật bộ đếm
    document.getElementById('counter').innerText = `${currentIndex + 1}/${flashcards.length}`;
    
    // Cập nhật thanh tiến trình
    const progress = ((currentIndex + 1) / flashcards.length) * 100;
    document.getElementById('progress-bar').style.width = `${progress}%`;
}

function nextCard() {
    if(currentIndex < flashcards.length - 1) {
        currentIndex++;
        renderCard();
    } else {
        // Hiệu ứng khi hoàn thành
        alert("Chúc mừng! Bạn đã học hết từ vựng trong chủ đề này.");
        // Reset về đầu (tuỳ chọn)
        currentIndex = 0;
        renderCard();
    }
}

function prevCard() {
    if(currentIndex > 0) {
        currentIndex--;
        renderCard();
    }
}

// Chức năng phát âm (Text to Speech)
function speakCurrentWord() {
    if(flashcards.length === 0) return;
    
    const word = flashcards[currentIndex].word;
    
    // Kiểm tra trình duyệt có hỗ trợ không
    if ('speechSynthesis' in window) {
        const utterance = new SpeechSynthesisUtterance(word);
        utterance.lang = 'en-US'; 
        utterance.rate = 0.9; // Tốc độ hơi chậm một chút cho dễ nghe
        window.speechSynthesis.speak(utterance);
    } else {
        alert("Trình duyệt của bạn không hỗ trợ phát âm.");
    }
}