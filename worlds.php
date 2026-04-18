<?php 
require_once 'inc/db.php';
session_start();

$sql = "SELECT worlds.*, users.login AS author, users.avatar AS author_avatar 
        FROM worlds 
        JOIN users ON worlds.user_id = users.id 
        ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$worlds = $stmt->fetchAll();

include 'inc/header.php';
?>

<h2 class="mb-4 text-center">Вселенная «МироТворца»</h2>
<p class="text-center text-muted">Исследуйте миры, созданные другими авторами</p>

<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($worlds as $world): ?>
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <?php if ($world['author_avatar']): ?>
                            <img src="uploads/<?= $world['author_avatar'] ?>" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                        <?php endif; ?>
                        <h6 class="card-subtitle text-muted small mb-0">Автор: <?= htmlspecialchars($world['author']) ?></h6>
                    </div>
                    <?php if ($world['image']): ?>
                        <img src="uploads/<?= $world['image'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    <h5 class="card-title"><?= htmlspecialchars($world['title']) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted small">Автор: <?= htmlspecialchars($world['author']) ?></h6>
                    <span class="badge bg-light text-dark border mb-2"><?= htmlspecialchars($world['genre']) ?></span>
                    <p class="card-text text-truncate"><?= htmlspecialchars($world['description']) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'inc/footer.php'; ?>