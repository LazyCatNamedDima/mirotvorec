<?php
require_once 'inc/db.php';
session_start();

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

if (isset($_GET['id'])) {
    $char_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Проверяем, что персонаж принадлежит миру, который принадлежит этому пользователю
    $sql = "DELETE characters FROM characters 
            JOIN worlds ON characters.world_id = worlds.id 
            WHERE characters.id = :char_id AND worlds.user_id = :user_id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['char_id' => $char_id, 'user_id' => $user_id]);
}

header("Location: profile.php");
exit;