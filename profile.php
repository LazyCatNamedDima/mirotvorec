<?php 
require_once 'inc/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM worlds WHERE user_id = :user_id ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$my_worlds = $stmt->fetchAll();

include 'inc/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Мои миры</h2>
    <a href="create.php" class="btn btn-primary">+ Создать еще</a>
</div>

<?php if (empty($my_worlds)): ?>
    <div class="alert alert-info text-center">
        Вы еще не создали ни одного мира. Пора <a href="create.php">начать творить</a>!
    </div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php foreach ($my_worlds as $world): ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <?php if ($world['image']): ?>
                            <img src="uploads/<?= $world['image'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                    
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title text-primary"><?= htmlspecialchars($world['title']) ?></h5>
                            <span class="badge bg-secondary"><?= htmlspecialchars($world['genre']) ?></span>
                        </div>
                        <p class="card-text mt-2"><?= nl2br(htmlspecialchars($world['description'])) ?></p>

                        <div class="mt-3">
                            <h6>👥 Персонажи:</h6>
                            <?php
                            
                            $stmt_chars = $pdo->prepare("SELECT * FROM characters WHERE world_id = ?");
                            $stmt_chars->execute([$world['id']]);
                            $chars = $stmt_chars->fetchAll();

                            if ($chars): ?>
                                <ul class="list-unstyled small">
                                    <?php foreach ($chars as $char): ?>
                                        <li class="border-bottom py-1 d-flex justify-content-between align-items-center">
                                            <span>
                                                <strong><?= htmlspecialchars($char['name']) ?></strong> 
                                                <span class="text-muted">— <?= htmlspecialchars($char['role']) ?></span>
                                            </span>
                                            <a href="delete_character.php?id=<?= $char['id'] ?>" class="text-danger" style="text-decoration:none;" onclick="return confirm('Удалить героя?')">Удалить</a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-muted small">Героев пока нет...</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-transparent border-top-0 d-flex justify-content-end gap-2">
                        <a href="add_character.php?world_id=<?= $world['id'] ?>" class="btn btn-sm btn-outline-info">+ Герой</a>
                        <a href="edit.php?id=<?= $world['id'] ?>" class="btn btn-sm btn-outline-warning">Редактировать</a>
                        <a href="delete.php?id=<?= $world['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include 'inc/footer.php'; ?>