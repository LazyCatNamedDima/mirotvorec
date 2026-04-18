<?php 
require_once 'inc/db.php';
session_start();

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$my_id = $_SESSION['user_id'];

$sql = "SELECT DISTINCT 
            CASE WHEN sender_id = :id1 THEN receiver_id ELSE sender_id END as contact_id
        FROM messages 
        WHERE sender_id = :id2 OR receiver_id = :id3";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    'id1' => $my_id,
    'id2' => $my_id,
    'id3' => $my_id
]);
$contacts = $stmt->fetchAll();

include 'inc/header.php';
?>

<h2 class="mb-4">Мои диалоги</h2>

<div class="list-group shadow-sm">
    <?php if (empty($contacts)): ?>
        <div class="list-group-item text-center py-5 text-muted">
            У вас пока нет активных переписок.
        </div>
    <?php else: ?>
        <?php foreach ($contacts as $c):
            $stmt_u = $pdo->prepare("SELECT id, login, avatar FROM users WHERE id = ?");
            $stmt_u->execute([$c['contact_id']]);
            $user = $stmt_u->fetch();

            $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM messages WHERE sender_id = ? AND receiver_id = ? AND is_read = 0");
            $stmt_count->execute([$user['id'], $my_id]);
            $unread = $stmt_count->fetchColumn();
        ?>
            <a href="chat.php?receiver_id=<?= $user['id'] ?>" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between p-3">
                <div class="d-flex align-items-center">
                    <?php if ($user['avatar']): ?>
                        <img src="uploads/<?= $user['avatar'] ?>" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-light rounded-circle me-3 text-center" style="width: 50px; height: 50px; line-height: 50px;">👤</div>
                    <?php endif; ?>
                    <span class="fw-bold"><?= htmlspecialchars($user['login']) ?></span>
                </div>
                <?php if ($unread > 0): ?>
                    <span class="badge bg-danger rounded-pill">+<?= $unread ?></span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include 'inc/footer.php'; ?>