<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="min-h-screen bg-gray-50 pt-10 pb-12 fade-in">
    <div class="container mx-auto px-4 max-w-2xl">
        
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="<?php echo URLROOT; ?>/admin" class="w-10 h-10 rounded-full bg-white shadow flex items-center justify-center text-gray-500 hover:text-blue-600 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="text-2xl font-bold text-gray-800">Chỉnh sửa từ vựng</h2>
        </div>

        <!-- Form Edit -->
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8">
            <form action="<?php echo URLROOT; ?>/admin/editFlashcard/<?php echo $data['flashcard']->id; ?>" method="POST" class="space-y-6">
                
                <!-- Topic -->
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2">Chủ đề</label>
                    <select name="topic" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                        <?php foreach($data['topics'] as $topic): ?>
                            <option value="<?php echo $topic->topic; ?>" <?php echo $topic->topic == $data['flashcard']->topic ? 'selected' : ''; ?>>
                                <?php echo $topic->topic; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Word -->
                    <div>
                        <label class="block text-sm font-bold text-gray-600 mb-2">Từ vựng (English)</label>
                        <input type="text" name="word" value="<?php echo $data['flashcard']->word; ?>" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 font-bold text-blue-700" required>
                    </div>
                    
                    <!-- Pronunciation -->
                    <div>
                        <label class="block text-sm font-bold text-gray-600 mb-2">Phiên âm</label>
                        <input type="text" name="pronunciation" value="<?php echo $data['flashcard']->pronunciation; ?>" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 font-serif italic">
                    </div>
                </div>

                <!-- Meaning -->
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2">Nghĩa (Tiếng Việt)</label>
                    <input type="text" name="meaning" value="<?php echo $data['flashcard']->meaning; ?>" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Image -->
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2">Link Ảnh (URL)</label>
                    <div class="flex gap-4 items-start">
                        <div class="flex-1">
                            <input type="text" name="image" id="img-input" value="<?php echo $data['flashcard']->image; ?>" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 text-sm" oninput="document.getElementById('preview-img').src = this.value">
                            <p class="text-xs text-gray-400 mt-2">Dán link ảnh mới vào đây để thay đổi.</p>
                        </div>
                        <!-- Preview ảnh -->
                        <div class="w-24 h-24 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center overflow-hidden shrink-0">
                            <img id="preview-img" src="<?php echo $data['flashcard']->image; ?>" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/150'">
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="pt-4 flex gap-4">
                    <button type="submit" class="flex-1 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition">
                        Lưu thay đổi
                    </button>
                    <a href="<?php echo URLROOT; ?>/admin" class="px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition">
                        Hủy
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>