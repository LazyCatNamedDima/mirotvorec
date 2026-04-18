<?php 
require_once 'inc/db.php';
session_start();

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$world_id = $_POST['world_id'] ?? $_GET['world_id'] ?? null;

if (!$world_id) { header("Location: profile.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $role = trim($_POST['role']);
    $desc = trim($_POST['description']);

    if (!empty($name) && is_numeric($world_id)) {
        $stmt = $pdo->prepare("INSERT INTO characters (world_id, name, role, description) VALUES (?, ?, ?, ?)");
        $stmt->execute([$world_id, $name, $role, $desc]);
        header("Location: profile.php");
        exit;
    }
}
include 'inc/header.php';
?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <h3>Добавить персонажа</h3>
        <form method="POST">
            <input type="hidden" name="world_id" value="<?= htmlspecialchars($world_id) ?>">
            
            <div class="mb-2">
                <label class="form-label">Имя героя</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Роль</label>
                <input type="text" name="role" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Биография</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-info">Сохранить персонажа</button>
            <a href="profile.php" class="btn btn-link text-secondary">Отмена</a>
        </form>
    </div>
</div>
<?php include 'inc/footer.php'; ?>