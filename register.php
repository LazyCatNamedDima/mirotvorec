<?php 
require_once 'inc/db.php';
include 'inc/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($login) || empty($email) || empty($password)) {
        $error = "Заполните все поля!";
    } else {
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO users (login, email, password) VALUES (:login, :email, :password)";
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([
                'login' => $login,
                'email' => $email,
                'password' => $hashedPassword
            ]);

            $success = "Регистрация прошла успешно! Теперь вы можете <a href='login.php'>войти</a>.";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = "Логин или Email уже заняты.";
            } else {
                $error = "Ошибка регистрации: " . $e->getMessage();
            }
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Регистрация</h3>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <form action="register.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Логин</label>
                        <input type="text" name="login" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Пароль</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Создать аккаунт</button>
                </form>
                <div class="text-center mt-3">
                    <small>Уже есть аккаунт? <a href="login.php">Войти</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>