<?php 
require_once 'config/app.php'; 
require_once 'config/db.php'; 

if(!isset($_SESSION['user_id'])) { redirect('login.php'); }

$user_id = $_SESSION['user_id'];
$receiver_id = $_GET['with'] ?? null;

if (!$receiver_id) { redirect('explore.php'); }

// 1. Get Receiver Details
$stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
$stmt->execute([$receiver_id]);
$receiver = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$receiver) { die("User not found."); }

// 2. Fetch Messages (Filtering out messages hidden by the current user)
$msg_query = "SELECT id, sender_id, receiver_id, message, created_at 
              FROM messages 
              WHERE (sender_id = ? AND receiver_id = ? AND deleted_by_sender = 0) 
              OR (sender_id = ? AND receiver_id = ? AND deleted_by_receiver = 0) 
              ORDER BY created_at ASC";
$stmt = $conn->prepare($msg_query);
$stmt->execute([$user_id, $receiver_id, $receiver_id, $user_id]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php'; 
?>

<div class="container mx-auto px-6 py-10 max-w-4xl">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-[700px]">
        
        <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-white">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-md">
                    <?php echo strtoupper(substr($receiver['name'], 0, 1)); ?>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900"><?php echo htmlspecialchars($receiver['name']); ?></h3>
                    <span class="text-[10px] text-green-500 font-bold uppercase tracking-widest flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Active Conversation
                    </span>
                </div>
            </div>
            <a href="inbox.php" class="text-gray-400 hover:text-gray-600 text-sm font-bold">&larr; Back to Inbox</a>
        </div>

        <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-slate-50/50" id="chat-box">
            <?php if(empty($messages)): ?>
                <div class="text-center py-20">
                    <p class="text-gray-400 italic text-sm">Send a message to start swapping skills!</p>
                </div>
            <?php else: ?>
                <?php foreach($messages as $msg): 
                    $is_mine = ($msg['sender_id'] == $user_id);
                ?>
                    <div class="flex <?php echo $is_mine ? 'justify-end' : 'justify-start'; ?> group relative mb-2">
                        <div class="relative max-w-[75%]">
                            <div class="p-4 rounded-2xl shadow-sm <?php echo $is_mine ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white text-gray-800 border border-gray-100 rounded-bl-none'; ?>">
                                <p class="text-sm leading-relaxed"><?php echo htmlspecialchars($msg['message']); ?></p>
                                <span class="text-[10px] opacity-60 mt-2 block <?php echo $is_mine ? 'text-right' : 'text-left'; ?>">
                                    <?php echo date('H:i', strtotime($msg['created_at'])); ?>
                                </span>
                            </div>

                            <a href="delete_message.php?id=<?php echo $msg['id']; ?>" 
                               onclick="return confirm('Remove this message from your view?')"
                               class="absolute <?php echo $is_mine ? '-left-10' : '-right-10'; ?> top-1/2 -translate-y-1/2 p-2 text-gray-300 hover:text-red-500 transition opacity-0 group-hover:opacity-100">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <form action="send_message.php" method="POST" class="p-6 border-t border-gray-100 bg-white flex gap-4">
            <input type="hidden" name="receiver_id" value="<?php echo $receiver_id; ?>">
            <input type="text" name="message" placeholder="Type a message..." class="flex-1 px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 transition shadow-inner" required autocomplete="off">
            <button type="submit" class="bg-blue-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center gap-2">
                <span>Send</span>
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>