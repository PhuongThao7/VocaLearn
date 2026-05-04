<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- CSS cho hiệu ứng lật -->
<style>
    /* Hiệu ứng 3D lật thẻ */
    .perspective-1000 { perspective: 1000px; }
    .flashcard-container {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
    }
    .flashcard-container.flipped { transform: rotateY(180deg); }
    .flashcard-front, .flashcard-back {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        top: 0; left: 0;
    }
    .flashcard-back { transform: rotateY(180deg); }
</style>

<!-- Hình nền Doraemon -->
<div class="min-h-[85vh] fade-in flex flex-col justify-center relative bg-fixed" style="background-image: url('https://wallpapers.com/images/hd/doraemon-3d-winking-gl0955o05d30y5t8.jpg'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-blue-900/30 mix-blend-multiply z-0"></div>

    <div class="max-w-4xl mx-auto w-full px-4 relative z-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4 px-4">
            <a href="<?php echo URLROOT; ?>/flashcard" class="text-white hover:text-blue-200 font-semibold flex items-center gap-2 transition drop-shadow-md">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <span id="counter" class="text-sm font-bold text-blue-700 bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full shadow-sm">1 / <?php echo count($data['flashcards']); ?></span>
        </div>

        <?php if(empty($data['flashcards'])): ?>
            <div class="bg-white/90 backdrop-blur-md p-8 rounded-3xl text-center shadow-lg mx-auto max-w-lg">
                <p class="text-gray-500 font-medium">Chưa có từ vựng nào.</p>
                <a href="<?php echo URLROOT; ?>/flashcard" class="mt-4 inline-block text-blue-600 font-bold hover:underline">Chọn chủ đề khác</a>
            </div>
        <?php else: ?>
            <!-- Data Cards (Truyền JSON) -->
            <div id="flashcard-app" 
                data-cards="<?php echo htmlspecialchars(json_encode($data['flashcards']), ENT_QUOTES, 'UTF-8'); ?>" 
                class="w-full flex flex-col items-center">

                <div class="relative w-full max-w-2xl h-[550px] perspective-1000 group"> 
                    <div id="card-inner" class="flashcard-container w-full h-full cursor-pointer relative" onclick="toggleFlip()">
                        
                        <!-- MẶT TRƯỚC -->
                        <div class="flashcard-front bg-white/95 backdrop-blur-sm rounded-[2.5rem] shadow-2xl shadow-blue-900/20 border-4 border-white/50 flex flex-col items-center overflow-hidden">
                            <div class="w-full h-[65%] bg-blue-50/50 flex items-center justify-center p-4 relative overflow-hidden">
                                <img id="card-img-front" src="" onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=Image+Not+Found';" class="h-full w-auto object-contain drop-shadow-xl hover:scale-110 transition-transform duration-500">
                            </div>

                            <div class="w-full h-[35%] flex flex-col items-center justify-center bg-white relative z-20 -mt-8 pt-6 rounded-t-[2.5rem]">
                                <button onclick="event.stopPropagation(); speakCurrentWord()" class="absolute -top-7 bg-blue-600 text-white w-14 h-14 rounded-full shadow-lg hover:bg-blue-700 hover:scale-110 transition flex items-center justify-center group/audio z-30 ring-4 ring-white">
                                    <i class="fas fa-volume-up text-xl group-hover/audio:animate-pulse"></i>
                                </button>

                                <h2 id="card-word" class="text-5xl font-extrabold text-gray-800 mb-2 mt-2 tracking-tight">Loading...</h2>
                                <p id="card-pronun" class="text-xl text-gray-400 font-serif italic">/ ... /</p>
                                <p class="text-xs text-gray-300 font-medium uppercase tracking-widest mt-3">Chạm để xem nghĩa</p>
                            </div>
                        </div>

                        <!-- MẶT SAU (ĐÃ THÊM EXAMPLE) -->
                        <div class="flashcard-back bg-white/95 backdrop-blur-sm rounded-[2.5rem] shadow-2xl shadow-blue-900/20 border-4 border-white/50 flex flex-col items-center overflow-hidden relative">
                            <div class="w-full h-[65%] bg-green-50/50 flex items-center justify-center p-4 relative overflow-hidden">
                                <img id="card-img-back" src="" onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=Image+Not+Found';" class="h-full w-auto object-contain drop-shadow-xl hover:scale-110 transition-transform duration-500" style="filter: hue-rotate(15deg);"> 
                            </div>

                            <div class="w-full h-[35%] flex flex-col items-center justify-center bg-white relative z-20 -mt-8 pt-6 rounded-t-[2.5rem]">
                                <span class="absolute top-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nghĩa Tiếng Việt</span>
                                <h3 id="card-meaning" class="text-4xl md:text-5xl font-extrabold text-blue-600 mb-2 mt-2 leading-tight text-center px-4">Loading...</h3>
                                
                                <p id="card-example" class="text-lg text-gray-700 italic mt-3 px-6 text-center leading-relaxed">
                                    <!-- Example content goes here -->
                                </p>
                                
                                <button onclick="event.stopPropagation(); speakCurrentWord()" class="mt-2 w-10 h-10 rounded-full bg-gray-50 text-gray-400 hover:bg-blue-100 hover:text-blue-600 transition flex items-center justify-center"><i class="fas fa-volume-up"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- THANH ĐIỀU HƯỚNG -->
                <div class="bg-white/90 backdrop-blur-md p-2 rounded-2xl shadow-lg border border-white/50 mt-8 flex items-center gap-4">
                    <button onclick="prevCard()" class="w-12 h-12 rounded-xl text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition flex items-center justify-center">
                        <i class="fas fa-chevron-left text-xl"></i>
                    </button>
                    <button onclick="toggleFlip()" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold shadow-md hover:bg-blue-700 hover:shadow-lg transition flex items-center gap-2 min-w-[140px] justify-center">
                        <i class="fas fa-sync-alt text-sm"></i> Lật thẻ
                    </button>
                    <button onclick="nextCard()" class="w-12 h-12 rounded-xl text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition flex items-center justify-center">
                        <i class="fas fa-chevron-right text-xl"></i>
                    </button>
                </div>

            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    const appDiv = document.getElementById('flashcard-app');
    const baseUrl = "<?php echo rtrim(URLROOT, '/'); ?>"; 
    
    let flashcards = [];
    let currentIndex = 0;

    if(appDiv) {
        try {
            flashcards = JSON.parse(appDiv.dataset.cards);
            renderCard();
        } catch (e) { console.error("Lỗi dữ liệu JSON (đầu vào):", e); }
    }

    function toggleFlip() {
        document.getElementById('card-inner').classList.toggle('flipped');
    }

    function getImageUrl(imgPath) {
        if (!imgPath) return '';
        if (imgPath.startsWith('http')) return imgPath; // Link online
        
        let cleanPath = imgPath;
        if (cleanPath.startsWith('public/')) cleanPath = cleanPath.substring(7);
        if (cleanPath.startsWith('/')) cleanPath = cleanPath.substring(1);
        
        const finalUrl = `${baseUrl}/${cleanPath}`;
        
        return finalUrl;
    }

    function renderCard() {
        if(flashcards.length === 0) return;
        const card = flashcards[currentIndex];
        
        const imgSrc = getImageUrl(card.img);
        
        // GÁN ẢNH
        document.getElementById('card-img-front').src = imgSrc;
        document.getElementById('card-img-back').src = imgSrc; 
        
        // Cập nhật Text
        document.getElementById('card-word').innerText = card.word;
        document.getElementById('card-meaning').innerText = card.meaning;
        
        // CẬP NHẬT EXAMPLE MỚI THÊM
        // Sử dụng innerHTML vì câu example có thể chứa thẻ <strong>
        document.getElementById('card-example').innerHTML = card.example || "Không có câu ví dụ cho từ này.";
        
        let pronun = card.pronounce || '';
        if(pronun && !pronun.startsWith('/')) pronun = `/${pronun}/`;
        document.getElementById('card-pronun').innerText = pronun;
        
        const container = document.getElementById('card-inner');
        if(container.classList.contains('flipped')) container.classList.remove('flipped');
        document.getElementById('counter').innerText = `${currentIndex + 1} / ${flashcards.length}`;
    }

    function nextCard() {
        if(currentIndex < flashcards.length - 1) { currentIndex++; renderCard(); } 
        else { alert("Chúc mừng! Bạn đã hoàn thành chủ đề này."); currentIndex = 0; renderCard(); }
    }

    function prevCard() {
        if(currentIndex > 0) { currentIndex--; renderCard(); }
    }

    function speakCurrentWord() {
        if(flashcards.length === 0) return;
        const word = flashcards[currentIndex].word;
        if ('speechSynthesis' in window) {
            const utterance = new SpeechSynthesisUtterance(word);
            utterance.lang = 'en-US';
            utterance.rate = 0.8;
            window.speechSynthesis.speak(utterance);
        }
    }
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>