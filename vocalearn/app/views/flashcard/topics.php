<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="fade-in min-h-[80vh]">
    <div class="container mx-auto px-4">
        
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="<?php echo URLROOT; ?>/home/starter" 
               class="w-10 h-10 rounded-full bg-white shadow flex items-center justify-center text-gray-500 hover:text-blue-600 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="text-3xl font-bold text-gray-800">Chủ đề từ vựng</h2>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            <?php foreach($data['topics'] as $topic): ?>

                <?php 
                    // Xử lý đường dẫn ảnh
                    $imgSrc = $topic->image;
                    if (!empty($imgSrc) && !filter_var($imgSrc, FILTER_VALIDATE_URL)) {
                        $imgSrc = URLROOT . '/' . ltrim($imgSrc, '/');
                    }
                ?>

                <!-- CARD -->
                <a href="<?php echo URLROOT; ?>/flashcard/learn/<?php echo $topic->slug; ?>"
                   class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden transform hover:-translate-y-1">

                    <!-- IMAGE -->
                    <div class="h-40 overflow-hidden bg-gray-50 relative">
                        <img src="<?php echo $imgSrc; ?>" 
                             alt="<?php echo $topic->name; ?>"
                             onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black bg-opacity-10 group-hover:bg-opacity-0 transition"></div>
                    </div>

                    <!-- TEXT -->
                    <div class="p-5">
                        <h3 class="text-xl font-bold text-gray-800 mb-1 group-hover:text-blue-600 transition capitalize">
                            <?php echo $topic->name; ?>
                        </h3>

                        <p class="text-sm text-gray-500 flex items-center gap-2">
                            <i class="fas fa-layer-group text-blue-400"></i>
                            <?php echo $topic->word_count; ?> từ vựng
                        </p>
                    </div>
                </a>

            <?php endforeach; ?>

        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
