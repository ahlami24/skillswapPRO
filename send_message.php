<?php
require_once 'config/app.php';
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    $message_content = trim($_POST['message']);

    if (!empty($message_content)) {
        try {
            // Using 'message' column to match the SQL reset above
            $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
            $stmt->execute([$sender_id, $receiver_id, $message_content]);
            
            // Redirect back to the chat room
            header("Location: chat.php?with=" . $receiver_id);
            exit();
        } catch(PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }
    }
}

// Fallback: If something goes wrong, go to explore page
header("Location: explore.php");
exit();