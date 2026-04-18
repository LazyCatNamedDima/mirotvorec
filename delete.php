<?php
require_once 'inc/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $world_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $sql = "DELETE FROM worlds WHERE id = :id AND user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id' => $world_id,
        'user_id' => $user_id
    ]);
}

header("Location: profile.php");
exit;