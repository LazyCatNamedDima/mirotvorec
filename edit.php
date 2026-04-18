<?php
require_once 'inc/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = '';
$success = '';
$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $world_id = $_GET['id'];
    
    $stmt = $pdo->prepare("SELECT * FROM worlds WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['id' => $world_id, 'user_id' => $user_id]);
    $world = $stmt->fetch();

    if (!$world) {
        die("Мир не найден или у вас нет прав на его редактирование.");
    }
} else {
    header("Location: profile.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $description = trim($_POST['description']);

    if (empty($title)) {
        $error = "Название не может быть пустым!";
    } else {
        try {
            $sql = "UPDATE worlds SET title = :title, genre = :genre, description = :description 
                    WHERE id = :id AND user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'title' => $title,
                'genre' => $genre,
                'description' => $description,
                'id' => $world_id,
                'user_id' => $user_id
            ]);
            $success = "Изменения сохранены! <a href='profile.php'>Вернуться в список</a>";
            
            $world['title'] = $title;
            $world['genre'] = $genre;
            $world['description'] = $description;
        } catch (PDOException $e) {
            $error = "Ошибка при обновлении: " . $e->getMessage();
        }
    }
}

include 'inc/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-warning">
            <div class="card-body">
                <h2 class="card-title mb-4">Редактировать мир</h2>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <form action="edit.php?id=<?= $world['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Название мира</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($world['title']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Жанр</label>
                        <select name="genre" class="form-select">
                            <?php 
                            $genres = ['Фэнтези', 'Научная фантастика', 'Постапокалипсис', 'Киберпанк', 'Другое'];
                            foreach ($genres as $g) {
                                $selected = ($g == $world['genre']) ? 'selected' : '';
                                echo "<option value='$g' $selected>$g</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Описание мира</label>
                        <textarea name="description" class="form-control" rows="6"><?= htmlspecialchars($world['description']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="profile.php" class="text-secondary">Назад</a>
                        <button type="submit" class="btn btn-warning px-5">Сохранить изменения</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>