<?php 
require_once 'inc/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $description = trim($_POST['description']);
    $user_id = $_SESSION['user_id'];

    if (empty($title)) {
        $error = "Название мира обязательно!";
    } else {
        try {
            $sql = "INSERT INTO worlds (user_id, title, genre, description) 
                    VALUES (:user_id, :title, :genre, :description)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'user_id'     => $user_id,
                'title'       => $title,
                'genre'       => $genre,
                'description' => $description
            ]);
            
            $success = "Мир «" . htmlspecialchars($title) . "» успешно создан! <a href='profile.php'>Перейти в профиль</a>";
        } catch (PDOException $e) {
            $error = "Ошибка при сохранении: " . $e->getMessage();
        }
    }
}

include 'inc/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-4">Создать новый мир</h2>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <form action="create.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Название мира</label>
                        <input type="text" name="title" class="form-control" placeholder="Например: Средиземье" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Жанр</label>
                        <select name="genre" class="form-select">
                            <option value="Фэнтези">Фэнтези</option>
                            <option value="Научная фантастика">Научная фантастика</option>
                            <option value="Постапокалипсис">Постапокалипсис</option>
                            <option value="Киберпанк">Киберпанк</option>
                            <option value="Другое">Другое</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Описание мира</label>
                        <textarea name="description" class="form-control" rows="6" placeholder="Опишите основы вашего мира..."></textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="index.php" class="text-secondary">Отмена</a>
                        <button type="submit" class="btn btn-primary px-5">Воплотить мир</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>