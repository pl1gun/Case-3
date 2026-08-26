<?php 
require_once 'config/config.php'; 
requireLogin();

$post_id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if (!$post || $post['user_id'] != $_SESSION['user_id']) {
    header("Location: index.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$post_id]);
    
    header("Location: index.php?msg=deleted");
    exit;
} catch (PDOException $e) {
    header("Location: index.php?error=delete_failed");
    exit;
}
?>