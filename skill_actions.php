<?php
require_once 'config/app.php';
require_once 'config/db.php';

if(!isset($_SESSION['user_id'])) { redirect('login.php'); }
$user_id = $_SESSION['user_id'];
$action = $_GET['action'] ?? '';

if ($action == 'add' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['skill_name']);
    $type = $_POST['type'];
    $level = $_POST['level'];

    // 1. Get or Create Skill ID
    $stmt = $conn->prepare("SELECT id FROM skills WHERE name = ?");
    $stmt->execute([$name]);
    $skill = $stmt->fetch();

    if ($skill) {
        $skill_id = $skill['id'];
    } else {
        $stmt = $conn->prepare("INSERT INTO skills (name) VALUES (?)");
        $stmt->execute([$name]);
        $skill_id = $conn->lastInsertId();
    }

    // 2. Link to User
    $stmt = $conn->prepare("INSERT INTO user_skills (user_id, skill_id, type, skill_level) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $skill_id, $type, $level]);
    
    redirect('skills.php');
}

if ($action == 'delete') {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM user_skills WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    redirect('skills.php');
}