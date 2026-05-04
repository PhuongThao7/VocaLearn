<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="fade-in min-h-[80vh] py-10">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="<?php echo URLROOT; ?>/home/starter" class="w-10 h-10 rounded-full bg-white shadow flex items-center justify-center text-gray-500 hover:text-blue-600 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Danh sách bài kiểm tra</h2>
                <p class="text-gray-500 mt-1">Chọn một bài Quiz để kiểm tra từ vựng đã học.</p>
            </div>
        </div>

        <!-- Grid Danh sách Quiz (4 bài chính thức) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-6 max-w-5xl mx-auto">
            <?php foreach($data['quizzes'] as $quiz): ?>
                <?php 
                    // Gán màu sắc cho Quiz dựa trên ID
                    $colors = [
                        1 => ['main' => 'blue', 'desc' => 'Trường học & Giải trí'], 
                        2 => ['main' => 'green', 'desc' => 'Công việc & Thể thao'], 
                        3 => ['main' => 'purple', 'desc' => 'Đồ ăn & Động vật'], 
                        4 => ['main' => 'orange', 'desc' => 'Gia đình & Quần áo']
                    ];
                    $color = $colors[$quiz->id] ?? 'gray';
                    
                    $mainColor = $color['main'] ?? 'gray';
                    $descText = $color['desc'] ?? $quiz->description;
                    
                    // Lấy số lượng câu hỏi thực tế (đã được giới hạn 5 trong Model)
                    $displayCount = $quiz->count; 
                ?>
                <!-- Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:border-<?php echo $mainColor; ?>-200 transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group">
                    
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <span class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-1 block">QUIZ #<?php echo $quiz->id; ?></span>
                            <h3 class="text-2xl font-bold text-gray-800 mb-1 group-hover:text-<?php echo $mainColor; ?>-600 transition-colors"><?php echo $quiz->title; ?></h3>
                            
                            <!-- Hiển thị 5 câu hỏi (đã fix) -->
                            <p class="text-gray-500 text-sm mb-4">
                                <?php echo $displayCount; ?> câu hỏi • <?php echo $descText; ?>
                            </p>
                            
                            <span class="text-sm font-semibold text-gray-400">Sẵn sàng?</span>
                        </div>
                        
                        <!-- Icon Puzzle -->
                        <div class="w-16 h-16 rounded-2xl bg-<?php echo $mainColor; ?>-50 flex items-center justify-center text-<?php echo $mainColor; ?>-500 group-hover:scale-110 transition-transform">
                            <i class="fas fa-puzzle-piece text-2xl"></i>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-4">

                    <div class="flex justify-end items-center relative z-10">
                        <!-- Nút Bắt đầu -->
                        <a href="<?php echo URLROOT; ?>/quiz/play/<?php echo $quiz->id; ?>" class="px-6 py-2 bg-<?php echo $mainColor; ?>-600 text-white font-bold rounded-lg shadow-md hover:bg-<?php echo $mainColor; ?>-700 hover:shadow-lg transition-all transform active:scale-95">
                            Bắt đầu
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>