<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Nền xanh nhạt toàn trang -->
<div class="min-h-screen bg-blue-50/50 -mt-8 pt-8 pb-12 fade-in">
    <div class="container mx-auto px-4">
        
        <!-- Header Dashboard -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Admin Dashbooard </h1>
        </div>

        <!-- Grid 3 Cột -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- CỘT 1: USER -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden h-[700px] flex flex-col">
                <div class="p-6 border-b border-gray-50 flex items-center gap-3 bg-white sticky top-0 z-10">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="fas fa-users"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">User</h2>
                </div>
                <div class="p-4 overflow-y-auto custom-scrollbar flex-1">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-gray-50">
                            <?php foreach($data['users'] as $user): ?>
                            <tr class="group hover:bg-gray-50 transition">
                                <td class="py-3 pl-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-xs">
                                            <?php echo strtoupper(substr($user->username, 0, 1)); ?>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800 text-sm"><?php echo $user->fullname; ?></p>
                                            <span class="text-xs text-gray-400">@<?php echo $user->username; ?></span>
                                        </div>
                                    </div>
                                </td>
                               <td class="py-3 text-right pr-2">
                                    <?php if ($user->role !== 'admin' && $user->id != $_SESSION['user_id']): ?>
                                      <a href="<?php echo URLROOT; ?>/admin/deleteUser/<?php echo $user->id; ?>"
                                          onclick="return confirm('Xóa user này?')"
                                             class="text-red-400 hover:text-red-600">
                                             <i class="fas fa-trash-alt"></i>
                                             </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- CỘT 2: FLASHCARD -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden h-[700px] flex flex-col">
                <div class="p-6 border-b border-gray-50 flex items-center gap-3 bg-white sticky top-0 z-10">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Quản lý Flashcard</h2>
                </div>

                <div class="overflow-y-auto custom-scrollbar flex-1 p-6">
                    <!-- Form Thêm -->
                    <form action="<?php echo URLROOT; ?>/admin/addFlashcard" method="POST" class="space-y-3 mb-8 border-b border-gray-100 pb-6">
                        <h3 class="text-sm font-bold text-gray-400 uppercase">Thêm từ mới</h3>
                        <select name="topic" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-green-500">
                            <?php foreach($data['topics'] as $topic): ?>
                                <option value="<?= $topic->id ?>"><?= $topic->name ?></option>
                            <?php endforeach; ?>
                            <option value="">+ Chủ đề mới</option>
                        </select>
                        <input type="text" name="new_topic" placeholder="Nhập tên chủ đề mới..." class="w-full p-3 bg-white border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-green-500">
                        <input type="text" name="word" placeholder="Từ vựng (English)" class="w-full p-3 bg-gray-50 border rounded-xl text-sm outline-none focus:ring-2 focus:ring-green-500" required>
                        <input type="text" name="meaning" placeholder="Nghĩa (Tiếng Việt)" class="w-full p-3 bg-gray-50 border rounded-xl text-sm outline-none focus:ring-2 focus:ring-green-500" required>
                        <input type="text" name="pronunciation" placeholder="Phiên âm" class="w-full p-3 bg-gray-50 border rounded-xl text-sm outline-none focus:ring-2 focus:ring-green-500">
                        <input type="text" name="image" placeholder="Link ảnh" class="w-full p-3 bg-gray-50 border rounded-xl text-sm outline-none focus:ring-2 focus:ring-green-500">
                        <input type="text" name="example" placeholder="Ví dụ" class="w-full p-3 bg-gray-50 border rounded-xl text-sm outline-none focus:ring-2 focus:ring-green-500">
                        <button type="submit" class="w-full py-3 bg-green-500 text-white font-bold rounded-xl shadow-md hover:bg-green-600 transition">Thêm</button>
                    </form>

                    <!-- Danh sách Flashcard -->
                    <h3 class="text-sm font-bold text-gray-400 uppercase mb-3">Danh sách từ vựng</h3>
                    <div class="space-y-3">
                        <?php foreach($data['recent_flashcards'] as $card): ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-white hover:shadow-md transition border border-transparent hover:border-gray-100 group">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <?php
  
                                  if (preg_match('/^https?:\/\//', $card->img)) {
                                  $img = $card->img; // Ảnh URL ngoài → giữ nguyên
                              } else {
                                  $img = URLROOT . "/" . ltrim(str_replace("public/", "", $card->img), "/");
                              }
                          ?>
                            <img src="<?php echo $img; ?>" class="w-10 h-10 rounded-lg object-cover bg-white" 
                                onerror="this.src='https://via.placeholder.com/40'">
                                    <div class="min-w-0">
                                        <p class="font-bold text-gray-800 text-sm truncate"><?php echo $card->word; ?></p>
                                        <p class="text-xs text-gray-500 truncate"><?php echo $card->meaning; ?> • <span class="text-blue-500"><?php echo $card->topic_id; ?></span></p>
                                    </div>
                                </div>
                                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition">
                                    <button onclick="editImage(<?php echo $card->id; ?>, '<?php echo $card->img; ?>')" class="w-8 h-8 rounded-full bg-white text-gray-400 flex items-center justify-center shadow-sm hover:text-blue-500 hover:bg-blue-50 transition"><i class="far fa-image text-xs"></i></button>
                                    <a href="<?php echo URLROOT; ?>/admin/deleteFlashcard/<?php echo $card->id; ?>" onclick="return confirm('Xóa từ này?')" class="w-8 h-8 rounded-full bg-white text-gray-400 flex items-center justify-center shadow-sm hover:text-red-500 hover:bg-red-50 transition"><i class="fas fa-trash-alt text-xs"></i></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- CỘT 3: QUIZ (CẬP NHẬT PHẦN SELECT) -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden h-[700px] flex flex-col">
                <div class="p-6 border-b border-gray-50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                        <i class="fas fa-question"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Thêm Câu Hỏi</h2>
                </div>
                <div class="p-6 overflow-y-auto custom-scrollbar">
                    <form action="<?php echo URLROOT; ?>/admin/addQuiz" method="POST" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Chọn Quiz</label>
                            <!-- HIỂN THỊ DANH SÁCH QUIZ CHÍNH THỨC -->
                            <select name="quiz_id" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm">
                                <?php 
                                    // Danh sách Quiz chính thức (đã có trong bảng 'quizzes')
                                    $quizList = [
                                        1 => "School & Leisure",
                                        2 => "Work & Sport",
                                        3 => "Food & Animals",
                                        4 => "Family & Clothes"
                                    ];
                                ?>
                                <?php foreach($quizList as $id => $title): ?>
                                    <!-- Hiển thị tên đầy đủ -->
                                    <option value="<?php echo $id; ?>"><?php echo $id; ?>: <?php echo $title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <textarea name="question" rows="3" placeholder="Câu hỏi..." class="w-full p-3 bg-gray-50 border rounded-xl text-sm outline-none focus:ring-2 focus:ring-purple-500" required></textarea>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="option_a" placeholder="A" class="p-2 bg-gray-50 border rounded-lg text-sm" required>
                            <input type="text" name="option_b" placeholder="B" class="p-2 bg-gray-50 border rounded-lg text-sm" required>
                            <input type="text" name="option_c" placeholder="C" class="p-2 bg-gray-50 border rounded-lg text-sm" required>
                            <input type="text" name="option_d" placeholder="D" class="p-2 bg-gray-50 border rounded-lg text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Đáp án đúng</label>
                            <select name="correct_option" class="w-full p-3 bg-gray-50 border rounded-xl text-sm outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full py-3 bg-purple-500 text-white font-bold rounded-xl shadow-md hover:bg-purple-600 transition">Thêm</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function editImage(id, oldImg) {
    let newImg = prompt("Nhập link ảnh mới:", oldImg);
    if (newImg != null && newImg.trim() !== "") {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo URLROOT; ?>/admin/updateFlashcardImage';
        
        let idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'card_id';
        idInput.value = id;
        
        let imgInput = document.createElement('input');
        imgInput.type = 'hidden';
        imgInput.name = 'image_url';
        imgInput.value = newImg;
        
        form.appendChild(idInput);
        form.appendChild(imgInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>