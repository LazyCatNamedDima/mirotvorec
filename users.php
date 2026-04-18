<?php 
require_once 'inc/db.php';
session_start();

$current_user_id = $_SESSION['user_id'] ?? 0;
$stmt = $pdo->prepare("SELECT id, login, avatar FROM users WHERE id != ?");
$stmt->execute([$current_user_id]);
$all_users = $stmt->fetchAll();

include 'inc/header.php';
?>

<h2 class="mb-4">Пользователи проекта</h2>
<div class="row row-cols-1 row-cols-md-4 g-4">
    <?php foreach ($all_users as $u): ?>
        <div class="col">
            <div class="card h-100 text-center shadow-sm">
                <div class="card-body">
                    <?php if ($u['avatar']): ?>
                        <img src="uploads/<?= $u['avatar'] ?>" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-light rounded-circle d-inline-block mb-3" style="width: 80px; height: 80px; line-height: 80px;">👤</div>
                    <?php endif; ?>
                    <h5 class="card-title"><?= htmlspecialchars($u['login']) ?></h5>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="chat.php?receiver_id=<?= $u['id'] ?>" class="btn btn-outline-primary btn-sm">Написать сообщение</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'inc/footer.php'; ?>