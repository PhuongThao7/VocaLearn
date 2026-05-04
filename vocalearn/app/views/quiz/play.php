<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Container chính -->
<div class="min-h-[85vh] flex flex-col justify-center py-8 fade-in" style="background: linear-gradient(180deg, #EBF4FF 0%, #F5F7FA 100%);">
    <div class="container mx-auto px-4 max-w-3xl">

        <!-- Header: Tiêu đề Quiz & Nút thoát -->
        <div class="flex justify-between items-end mb-6" id="quiz-header">
            <div>
                <a href="<?php echo URLROOT; ?>/quiz" class="text-gray-500 hover:text-gray-600 text-sm font-semibold mb-1 inline-block"><i class="fas fa-chevron-left mr-1"></i> Thoát bài thi</a>
                <h1 class="text-2xl font-extrabold text-gray-800"><?php echo $data['quiz_title']; ?></h1>
            </div>
            <!-- Bộ đếm đã được di chuyển vào Quiz Slide, bỏ đoạn này -->
        </div>

        <!-- THANH TIẾN TRÌNH (Giữ nguyên) -->
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-8 overflow-hidden">
            <div id="progress-bar" class="bg-blue-600 h-2.5 rounded-full transition-all duration-500" style="width: 0%"></div>
        </div>

        <!-- KHUNG CÂU HỎI -->
        <div id="quiz-container" class="relative">
            <?php if(empty($data['questions'])): ?>
                <div class="text-center p-12 bg-white rounded-3xl shadow-lg">
                    <p class="text-gray-500">Chưa có dữ liệu câu hỏi.</p>
                    <a href="<?php echo URLROOT; ?>/quiz" class="mt-4 inline-block text-blue-600 font-bold">Quay lại</a>
                </div>
            <?php else: ?>
                <!-- Loop các câu hỏi -->
                <?php foreach($data['questions'] as $index => $q): ?>
                    <div class="quiz-slide hidden transition-opacity duration-300" id="question-<?php echo $index; ?>" data-correct="<?php echo $q->correct_option; ?>">
                        <div class="bg-white p-8 md:p-10 rounded-2xl shadow-xl border border-gray-100 relative">
                            
                            <!-- BỘ ĐẾM CÂU HỎI (ĐÃ CHUYỂN VÀO TRONG KHUNG) -->
                            <div class="absolute -top-3 -right-3 bg-yellow-100 text-yellow-700 font-bold px-4 py-1.5 rounded-full text-sm shadow-sm border border-yellow-200" id="slide-counter-<?php echo $index; ?>">
                                Câu <?php echo $index + 1; ?>/<?php echo count($data['questions']); ?>
                            </div>
                            
                            <!-- Nội dung câu hỏi -->
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 leading-relaxed pt-4">
                                <?php echo $q->question; ?>
                            </h2>
                            
                            <!-- Các đáp án -->
                            <div class="grid grid-cols-1 gap-4">
                                <?php 
                                    $options = [
                                        'A' => $q->option_a, 
                                        'B' => $q->option_b, 
                                        'C' => $q->option_c, 
                                        'D' => $q->option_d
                                    ]; 
                                ?>
                                <?php foreach($options as $key => $val): ?>
                                    <!-- Các nút đáp án: Bo góc nhẹ, nền trắng, border mỏng -->
                                    <button onclick="selectOption(<?php echo $index; ?>, '<?php echo $key; ?>', this)" 
                                            class="option-btn text-left p-4 rounded-xl border border-gray-200 hover:border-blue-300 hover:shadow-sm transition-all duration-200 flex items-center group bg-white">
                                        
                                        <!-- Key (A, B, C, D) -->
                                        <span class="w-6 h-6 rounded flex items-center justify-center mr-4 text-gray-600 font-bold text-sm border border-gray-300 group-hover:border-blue-500 group-hover:text-blue-600 transition-colors"><?php echo $key; ?></span>
                                        
                                        <!-- Value -->
                                        <span class="text-lg text-gray-700 font-medium"><?php echo $val; ?></span>
                                        
                                        <!-- Icons feedback (Đã đặt sát bên phải) -->
                                        <i class="fas fa-check text-xl ml-auto text-green-500 hidden icon-correct"></i>
                                        <i class="fas fa-times text-xl ml-auto text-red-500 hidden icon-wrong"></i>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Nút Tiếp theo (Đặt trong khung Quiz để canh lề) -->
                        <div class="mt-6 text-right">
                            <button id="next-btn-<?php echo $index; ?>" 
                                    onclick="nextQuestion()" 
                                    disabled 
                                    class="next-question-btn bg-gray-400 text-white px-8 py-3 rounded-xl font-bold shadow-md cursor-not-allowed transition transform inline-flex items-center">
                                Câu tiếp theo <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- MÀN HÌNH KẾT QUẢ -->
        <div id="result-screen" class="hidden fade-in text-center py-10">
            <div class="bg-white p-10 rounded-3xl shadow-2xl border border-gray-100 max-w-md mx-auto relative overflow-hidden">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 text-green-500 shadow-sm animate-bounce">
                    <i class="fas fa-trophy text-4xl"></i>
                </div>
                
                <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Hoàn thành!</h2>
                <p class="text-gray-500 mb-8">Bạn đã làm rất tốt.</p>

                <div class="bg-gray-50 rounded-2xl p-6 mb-8 border border-gray-100">
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wider mb-2">Điểm số của bạn</p>
                    <div class="text-5xl font-extrabold text-blue-600">
                        <span id="score-display">0</span><span class="text-2xl text-gray-400">/<?php echo count($data['questions']); ?></span>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button onclick="location.reload()" class="w-full py-3.5 rounded-xl border-2 border-gray-200 font-bold text-gray-600 hover:border-gray-400 hover:text-gray-800 transition">
                        <i class="fas fa-redo-alt mr-2"></i> Làm lại
                    </button>
                    <a href="<?php echo URLROOT; ?>/quiz" class="w-full py-3.5 rounded-xl bg-blue-600 font-bold text-white hover:bg-blue-700 shadow-lg hover:shadow-blue-500/30 transition">
                        Danh sách bài thi <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LOGIC JS CHO QUIZ -->
<script>
    let currentIdx = 0;
    const questions = document.querySelectorAll('.quiz-slide');
    const totalQuestions = questions.length;
    let score = 0;
    
    // Lấy các DOM element cần thiết
    const progressBar = document.getElementById('progress-bar');
    
    // Khởi tạo: Hiện câu đầu tiên
    if(totalQuestions > 0) {
        showQuestion(0);
    }

    function showQuestion(index) {
        questions.forEach(q => q.classList.add('hidden'));
        questions[index].classList.remove('hidden');
        
        // --- FIX LỖI: Cập nhật thanh tiến trình ---
        // Thanh tiến trình chạy theo phần trăm đã hoàn thành
        const progress = (index / totalQuestions) * 100; // Tỷ lệ câu đã hoàn thành
        progressBar.style.width = `${progress}%`;
        
        // Vô hiệu hóa nút Next của câu hỏi hiện tại
        const nextBtn = document.getElementById(`next-btn-${index}`);
        nextBtn.disabled = true;
        nextBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'hover:shadow-lg', 'hover:-translate-y-0.5', 'cursor-pointer');
        nextBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
    }

    function selectOption(qIndex, selectedKey, btn) {
        const slide = document.getElementById(`question-${qIndex}`);
        if(slide.classList.contains('answered')) return; // Đã trả lời rồi thì không làm gì
        slide.classList.add('answered');

        const correctKey = slide.dataset.correct;
        const isCorrect = (selectedKey === correctKey);

        // Xử lý UI
        if(isCorrect) {
            score++;
            btn.classList.remove('border-gray-200', 'hover:border-blue-300', 'hover:shadow-sm');
            btn.classList.add('border-green-400', 'bg-green-100');
            btn.querySelector('.icon-correct').classList.remove('hidden');
        } else {
            btn.classList.remove('border-gray-200', 'hover:border-blue-300', 'hover:shadow-sm');
            btn.classList.add('border-red-400', 'bg-red-100');
            btn.querySelector('.icon-wrong').classList.remove('hidden');
            
            // Highlight đáp án đúng
            const allBtns = slide.querySelectorAll('.option-btn');
            allBtns.forEach(b => {
                const keySpan = b.querySelector('span:first-child');
                if(keySpan && keySpan.innerText.trim() === correctKey) {
                    b.classList.add('border-green-400', 'bg-green-100');
                    b.querySelector('.icon-correct').classList.remove('hidden');
                }
            });
        }

        // --- KÍCH HOẠT NÚT TIẾP THEO ---
        const nextBtn = document.getElementById(`next-btn-${qIndex}`);
        nextBtn.disabled = false;
        nextBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
        nextBtn.classList.add('bg-blue-600', 'hover:bg-blue-700', 'hover:shadow-lg', 'hover:-translate-y-0.5', 'cursor-pointer');
    }

    function nextQuestion() {
        // Chỉ tiếp tục nếu nút không bị disabled (Đã được chọn)
        const nextBtn = document.getElementById(`next-btn-${currentIdx}`);
        if(nextBtn.disabled) return; 

        if(currentIdx < totalQuestions - 1) {
            currentIdx++;
            
            // Reset trạng thái cho câu tiếp theo
            const nextSlide = document.getElementById(`question-${currentIdx}`);
            nextSlide.classList.remove('answered');
            nextSlide.querySelectorAll('.option-btn').forEach(btn => {
                btn.classList.remove('border-green-400', 'bg-green-100', 'border-red-400', 'bg-red-100');
                btn.classList.add('border-gray-200');
                btn.querySelector('.icon-correct')?.classList.add('hidden');
                btn.querySelector('.icon-wrong')?.classList.add('hidden');
            });
            
            showQuestion(currentIdx);
        } else {
            finishQuiz();
        }
    }

    function finishQuiz() {
        document.getElementById('quiz-container').classList.add('hidden');
        document.getElementById('quiz-header').classList.add('hidden');
        document.getElementById('result-screen').classList.remove('hidden');
        
        const scoreDisplay = document.getElementById('score-display');
        let currentScore = 0;
        const interval = setInterval(() => {
            if(currentScore < score) {
                 currentScore++;
            }
            scoreDisplay.innerText = currentScore;
            
            if(currentScore === score) {
                 clearInterval(interval);
            }
        }, 100);
    }
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>