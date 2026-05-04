<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
</head>
<body class="flex flex-col min-h-screen text-gray-800 font-sans bg-gray-50">
<header class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <!-- LOGO -->
        <a href="<?php echo URLROOT; ?>" class="flex items-center gap-2 text-2xl font-extrabold text-blue-600 hover:text-blue-700 transition">
            <div class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center shadow-lg shadow-blue-200">
                <i class="fas fa-book-open"></i>
            </div>
            <span>VocaLearn</span>
        </a>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <!-- Menu chính -->
            <nav class="hidden md:flex items-center gap-8 font-bold text-gray-500">
                
                <!-- FLASHCARD DROPDOWN -->
                <div class="relative group py-3">
                    <button class="hover:text-blue-600 transition flex items-center gap-1 group-hover:text-blue-600 focus:outline-none">
                        Flashcard <i class="fas fa-chevron-down text-[10px] mt-0.5 transition-transform group-hover:rotate-180"></i>
                    </button>
                    
                    <!-- Dropdown Content -->
                    <div class="absolute top-full -left-4 pt-2 w-60 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-2 z-50">
                        <div class="absolute top-0 left-8 w-4 h-4 bg-white transform rotate-45 border-l border-t border-gray-100 z-20"></div>
                        
                        <div class="relative bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden z-10">
                            <!-- Starter: Link tới danh sách chủ đề Flashcard -->
                            <a href="<?php echo URLROOT; ?>/flashcard" class="block px-5 py-3 hover:bg-blue-50 border-b border-gray-50 transition group/item">
                                <div class="text-gray-800 font-bold group-hover/item:text-blue-600 flex justify-between items-center">
                                    Starter <i class="fas fa-star text-yellow-400 text-xs"></i>
                                </div>
                                <div class="text-xs text-gray-400 mt-0.5">Tiếng Anh cơ bản</div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- QUIZ DROPDOWN (MỚI THÊM) -->
                <div class="relative group py-3">
                    <button class="hover:text-blue-600 transition flex items-center gap-1 group-hover:text-blue-600 focus:outline-none">
                        Quiz <i class="fas fa-chevron-down text-[10px] mt-0.5 transition-transform group-hover:rotate-180"></i>
                    </button>
                    
                    <!-- Dropdown Content -->
                    <div class="absolute top-full -left-4 pt-2 w-60 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-2 z-50">
                        <div class="absolute top-0 left-8 w-4 h-4 bg-white transform rotate-45 border-l border-t border-gray-100 z-20"></div>
                        
                        <div class="relative bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden z-10">
                            <!-- Starter: Link tới danh sách bài Quiz -->
                            <a href="<?php echo URLROOT; ?>/quiz" class="block px-5 py-3 hover:bg-blue-50 border-b border-gray-50 transition group/item">
                                <div class="text-gray-800 font-bold group-hover/item:text-blue-600 flex justify-between items-center">
                                    Starter <i class="fas fa-star text-yellow-400 text-xs"></i>
                                </div>
                                <div class="text-xs text-gray-400 mt-0.5">Bài tập cơ bản</div>
                            </a>
                        </div>
                    </div>
                </div>

            </nav>

            <!-- User Area -->
            <div class="flex items-center gap-4">
                <!-- Nút Admin (Chỉ hiện nếu là Admin) -->
                <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                    <a href="<?php echo URLROOT; ?>/admin" class="flex items-center gap-2 bg-slate-100 text-slate-700 px-4 py-2 rounded-full font-bold text-sm hover:bg-slate-200 transition border border-slate-200">
                        <i class="fas fa-user-shield"></i> Quản trị
                    </a>
                <?php endif; ?>

                <!-- Thông tin user -->
                <div class="flex items-center gap-2 pl-4 border-l border-gray-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs text-gray-400 font-bold uppercase">Xin chào,</p>
                        <p class="text-sm font-bold text-gray-800"><?php echo $_SESSION['user_name'] ?? 'Bạn'; ?></p>
                    </div>
                    <a href="<?php echo URLROOT; ?>/auth/logout" class="w-9 h-9 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition" title="Đăng xuất">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="flex gap-3">
                <a href="<?php echo URLROOT; ?>/auth/login" class="px-6 py-2.5 text-gray-600 font-bold hover:bg-gray-50 rounded-full transition">Đăng nhập</a>
                <a href="<?php echo URLROOT; ?>/auth/register" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-full hover:bg-blue-700 shadow-lg shadow-blue-200 transition">Đăng ký</a>
            </div>
        <?php endif; ?>
    </div>
</header>
<main class="flex-grow">