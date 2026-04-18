<?php 
require_once 'inc/db.php';
session_start();

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$user_id = $_SESSION['user_id'];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES['avatar']['name'])) {
    $avatar_name = time() . '_' . $_FILES['avatar']['name'];
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], 'uploads/' . $avatar_name)) {
        $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        $stmt->execute([$avatar_name, $user_id]);
        $success = "Аватарка обновлена!";
    }
}

// Получаем текущие данные пользователя
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$curr_user = $stmt->fetch();

include 'inc/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h3>Настройки профиля</h3>
                <?php if ($success): ?> <div class="alert alert-success"><?= $success ?></div> <?php endif; ?>
                
                <div class="mb-3">
                    <?php if ($curr_user['avatar']): ?>
                        <img src="uploads/<?= $curr_user['avatar'] ?>" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-light rounded-circle d-inline-block" style="width: 150px; height: 150px; line-height: 150px;">Нет фото</div>
                    <?php endif; ?>
                </div>

                <form method="POST" enctype="multipart/form-data">
                    <input type="file" name="avatar" class="form-control mb-3" required>
                    <button type="submit" class="btn btn-primary">Загрузить фото</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>