<?php 
// Detect the current file name to highlight the correct link
$current_page = basename($_SERVER['PHP_SELF']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Smooth underline transition */
        .nav-link { position: relative; padding-bottom: 4px; }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #2563eb;
            transform-origin: bottom right;
            transition: transform 0.3s ease-out;
        }
        .nav-link:hover::after, .nav-link.active::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }
    </style>
</head>
<body class="bg-slate-50 text-gray-900 font-sans">
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-black text-blue-600 tracking-tighter italic">
                SkillSwap<span class="text-gray-900">PRO</span>
            </a>
            
            <div class="flex gap-8 items-center">
                <?php if(isset($_SESSION['user_id'])): ?>
                    
                    <a href="dashboard.php" class="nav-link font-bold transition <?= $current_page == 'dashboard.php' ? 'text-blue-600 active' : 'text-gray-600 hover:text-blue-600' ?>">
                        Dashboard
                    </a>

                    <a href="manage_skills.php" class="nav-link font-bold transition <?= $current_page == 'manage_skills.php' ? 'text-blue-600 active' : 'text-gray-600 hover:text-blue-600' ?>">
                        My Skills
                    </a>

                    <a href="explore.php" class="nav-link font-bold transition <?= $current_page == 'explore.php' ? 'text-blue-600 active' : 'text-gray-600 hover:text-blue-600' ?>">
                        Explore
                    </a>

                    <a href="inbox.php" class="nav-link font-bold transition <?= ($current_page == 'inbox.php' || $current_page == 'chat.php') ? 'text-blue-600 active' : 'text-gray-600 hover:text-blue-600' ?>">
                        Messages
                    </a>

                    <a href="logout.php" class="text-red-500 font-bold hover:text-red-700 ml-4 transition">Logout</a>

                <?php else: ?>
                    <a href="login.php" class="font-bold text-gray-600 hover:text-blue-600 transition">Login</a>
                    <a href="register.php" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100">Join</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>