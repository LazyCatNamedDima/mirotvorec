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
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title text-primary"><?= htmlspecialchars($world['title']) ?></h5>
                            <span class="badge bg-secondary"><?= htmlspecialchars($world['genre']) ?></span>
                        </div>
                        <p class="card-text text-muted mt-2">
                            <?= mb_strimwidth(htmlspecialchars($world['description']), 0, 150, "...") ?>
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 d-flex justify-content-end gap-2">
                        <a href="edit.php?id=<?= $world['id'] ?>" class="btn btn-sm btn-outline-warning">Редактировать</a>
                        <a href="delete.php?id=<?= $world['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                        <a href="add_character.php?world_id=<?= $world['id'] ?>" class="btn btn-sm btn-outline-info">+ Герой</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include 'inc/footer.php'; ?>