<?php 
require_once 'config/app.php'; 
require_once 'config/db.php'; 

if(!isset($_SESSION['user_id'])) { redirect('login.php'); }
$user_id = $_SESSION['user_id'];

// Fetch everyone you have shared messages with
$query = "SELECT DISTINCT u.id, u.name 
          FROM users u 
          JOIN messages m ON (u.id = m.sender_id OR u.id = m.receiver_id) 
          WHERE (m.sender_id = ? OR m.receiver_id = ?) AND u.id != ?";
$stmt = $conn->prepare($query);
$stmt->execute([$user_id, $user_id, $user_id]);
$chats = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php'; 
?>

<div class="container mx-auto px-6 py-10 max-w-2xl">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Conversations</h1>
    
    <div class="space-y-4">
        <?php if(empty($chats)): ?>
            <div class="bg-white p-12 rounded-3xl text-center border-2 border-dashed border-gray-100">
                <div class="text-gray-300 text-5xl mb-4"><i class="fa-regular fa-comments"></i></div>
                <p class="text-gray-500">No messages yet.</p>
                <a href="explore.php" class="text-blue-600 font-bold hover:underline mt-2 inline-block">Find someone to swap skills with!</a>
            </div>
        <?php else: foreach($chats as $chat): ?>
            <a href="chat.php?with=<?php echo $chat['id']; ?>" class="block bg-white p-6 rounded-2xl border border-gray-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-tr from-blue-600 to-blue-400 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">
                        <?php echo strtoupper(substr($chat['name'], 0, 1)); ?>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900 text-lg"><?php echo htmlspecialchars($chat['name']); ?></h4>
                        <p class="text-sm text-blue-600 font-medium">Click to continue conversation &rarr;</p>
                    </div>
                </div>
            </a>
        <?php endforeach; endif; ?>
    </div>
</div>