<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Giao diện giống hình 2 -->
<div class="min-h-[80vh] fade-in" style="background: linear-gradient(180deg, #FFFFFF 0%, #EBF4FF 100%);">
    <div class="container mx-auto px-4 py-12">
        
        <!-- Nút quay lại -->
        <a href="<?php echo URLROOT; ?>/home" class="text-gray-500 hover:text-blue-600 mb-8 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại trang chủ
        </a>

        <!-- Tiêu đề -->
        <div class="mb-12">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-2">Cấp độ Starter</h1>
            <p class="text-gray-500 text-lg">Lựa chọn phương pháp học tập phù hợp với bạn.</p>
        </div>

        <!-- 2 Khung lựa chọn lớn -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            
            <!-- Card 1: Flashcards -->
            <a href="<?php echo URLROOT; ?>/flashcard" class="group block bg-white rounded-[2rem] p-8 shadow-sm hover:shadow-2xl transition-all duration-300 border border-blue-50 hover:border-blue-200 relative overflow-hidden">
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-6">
                        <!-- Icon Box -->
                        <div class="w-20 h-20 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-layer-group text-3xl"></i>
                        </div>
                        <!-- Text -->
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">Flashcards</h3>
                            <p class="text-gray-500 mt-1">Học từ vựng qua hình ảnh trực quan.</p>
                        </div>
                    </div>
                    <!-- Arrow -->
                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <!-- Decorative Circle -->
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-blue-50 rounded-full opacity-0 group-hover:opacity-50 transition-opacity duration-500"></div>
            </a>

            <!-- Card 2: Quiz Game -->
            <a href="<?php echo URLROOT; ?>/quiz" class="group block bg-white rounded-[2rem] p-8 shadow-sm hover:shadow-2xl transition-all duration-300 border border-green-50 hover:border-green-200 relative overflow-hidden">
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-6">
                        <!-- Icon Box -->
                        <div class="w-20 h-20 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-puzzle-piece text-3xl"></i>
                        </div>
                        <!-- Text -->
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 group-hover:text-green-600 transition-colors">Quiz Game</h3>
                            <p class="text-gray-500 mt-1">Kiểm tra kiến thức và ghi điểm.</p>
                        </div>
                    </div>
                    <!-- Arrow -->
                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-green-600 group-hover:text-white transition-all">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                 <!-- Decorative Circle -->
                 <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-green-50 rounded-full opacity-0 group-hover:opacity-50 transition-opacity duration-500"></div>
            </a>

        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>