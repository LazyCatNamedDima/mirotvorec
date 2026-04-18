<?php 
require_once 'inc/db.php';
session_start();

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$my_id = $_SESSION['user_id'];
$receiver_id = $_GET['receiver_id'] ?? null;

if (!$receiver_id) { header("Location: users.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['text']))) {
    $text = trim($_POST['text']);
    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->execute([$my_id, $receiver_id, $text]);
    header("Location: chat.php?receiver_id=" . $receiver_id);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM messages 
                       WHERE (sender_id = ? AND receiver_id = ?) 
                       OR (sender_id = ? AND receiver_id = ?) 
                       ORDER BY created_at ASC");
$stmt->execute([$my_id, $receiver_id, $receiver_id, $my_id]);
$messages = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT login FROM users WHERE id = ?");
$stmt->execute([$receiver_id]);
$receiver = $stmt->fetch();

include 'inc/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                Чат с <strong><?= htmlspecialchars($receiver['login']) ?></strong>
            </div>
            <div class="card-body" style="height: 400px; overflow-y: auto; background: #f0f2f5;">
                <?php if (empty($messages)): ?>
                    <p class="text-center text-muted">Сообщений пока нет. Напишите первым!</p>
                <?php else: ?>
                    <?php foreach ($messages as $msg): ?>
                        <div class="mb-3 d-flex <?= $msg['sender_id'] == $my_id ? 'justify-content-end' : 'justify-content-start' ?>">
                            <div class="p-3 rounded-3 shadow-sm <?= $msg['sender_id'] == $my_id ? 'bg-primary text-white' : 'bg-white' ?>" style="max-width: 70%;">
                                <?= nl2br(htmlspecialchars($msg['message'])) ?>
                                <div class="small mt-1 <?= $msg['sender_id'] == $my_id ? 'text-white-50' : 'text-muted' ?>" style="font-size: 0.7rem;">
                                    <?= date('H:i', strtotime($msg['created_at'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="card-footer">
                <form method="POST" class="d-flex">
                    <input type="text" name="text" class="form-control me-2" placeholder="Введите сообщение..." required autocomplete="off">
                    <button type="submit" class="btn btn-primary px-4">Отправить</button>
                </form>
            </div>
        </div>
        <div class="text-center mt-3">
            <a href="users.php" class="text-secondary small">Вернуться к списку пользователей</a>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>