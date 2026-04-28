<?php
require_once 'config/app.php';
require_once 'config/db.php';

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $message_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // 1. Get the message info to see if the user is the sender or receiver
    $stmt = $conn->prepare("SELECT sender_id, receiver_id FROM messages WHERE id = ?");
    $stmt->execute([$message_id]);
    $msg = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($msg) {
        if ($msg['sender_id'] == $user_id) {
            // I sent this message, hide it from my view
            $update = $conn->prepare("UPDATE messages SET deleted_by_sender = 1 WHERE id = ?");
            $update->execute([$message_id]);
        } elseif ($msg['receiver_id'] == $user_id) {
            // I received this message, hide it from my view
            $update = $conn->prepare("UPDATE messages SET deleted_by_receiver = 1 WHERE id = ?");
            $update->execute([$message_id]);
        }
    }
}

// Redirect back to the chat screen
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    header("Location: inbox.php");
}
exit();