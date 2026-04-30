<?php 
require_once 'config/app.php'; 
require_once 'includes/header.php'; 
?>

<div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-sm border border-gray-100 p-10">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
            <?php if(isset($_GET['msg'])): ?>
                <p class="text-green-500 font-medium mt-2">Account created! Please login.</p>
            <?php else: ?>
                <p class="text-gray-500 mt-2">Login to manage your skills</p>
            <?php endif; ?>
        </div>

        <form action="login_handler.php" method="POST" class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                Sign In
            </button>
        </form>
    </div>
</div>