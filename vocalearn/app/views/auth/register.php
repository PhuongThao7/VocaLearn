<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Nền xanh nhạt toàn trang -->
<div class="min-h-[85vh] flex justify-center items-center py-12 bg-blue-50/50">
    <div class="w-full max-w-sm fade-in relative">
        
        <!-- Khung chính -->
        <div class="bg-white p-8 md:p-10 rounded-[2rem] shadow-2xl shadow-green-100 border border-gray-100 relative z-10">
            
            <!-- Icon Người dùng -->
            <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 w-20 h-20 bg-white rounded-full shadow-lg flex items-center justify-center border-4 border-green-50">
                <i class="fas fa-user-plus text-4xl text-green-600"></i>
            </div>

            <div class="text-center pt-10 mb-6">
                <h2 class="text-3xl font-extrabold text-gray-800 mb-1">Đăng ký</h2>
                <p class="text-gray-500 text-sm">Vui lòng điền thông tin để tiếp tục học.</p>
            </div>
            
            <?php if(isset($data['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-4 text-sm" role="alert">
                    <span class="block sm:inline"><?php echo $data['error']; ?></span>
                </div>
            <?php endif; ?>

            <form action="<?php echo URLROOT; ?>/auth/register" method="POST" class="space-y-5">
                
           

                <div class="relative">
                    <label for="fullname" class="block text-sm font-semibold text-gray-700 mb-2">Họ và tên</label>
                    <input type="text" id="fullname" name="fullname" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 transition text-gray-700" required>
                </div>
                
                <div class="relative">
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">Tên đăng nhập</label>
                    <input type="text" id="username" name="username" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 transition text-gray-700" placeholder="Ví dụ: hocsinh01" required>
                </div>
                
                <div class="relative">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Mật khẩu</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 transition text-gray-700" required>
                </div>
                
                <button type="submit" class="w-full bg-green-600 text-white font-bold py-3.5 rounded-xl hover:bg-green-700 shadow-lg shadow-green-500/30 transition transform hover:-translate-y-0.5 mt-6">
                    Đăng Ký
                </button>
            </form>
            
            <div class="mt-6 text-center text-sm">
                <a href="<?php echo URLROOT; ?>/auth/login" class="text-blue-600 font-bold hover:underline transition">Đã có tài khoản? Quay lại đăng nhập</a>
            </div>
        </div>
        
        <!-- Hình trang trí mờ -->
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-green-400 opacity-20 rounded-full blur-3xl pointer-events-none"></div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>