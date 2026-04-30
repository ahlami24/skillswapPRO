<?php
require_once 'config/app.php';
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
        
        // Success! Go to login
        redirect('login.php?msg=account_created');
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}