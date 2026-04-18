<?php 
require_once 'inc/db.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = $_POST['password'];

    if (!empty($login) && !empty($password)) {
        $sql = "SELECT * FROM users WHERE login = :login";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['login' => $login]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_login'] = $user['login'];

            header("Location: index.php");
            exit;
        } else {
            $error = "Неверный логин или пароль.";
        }
    } else {
        $error = "Введите логин и пароль!";
    }
}

include 'inc/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Вход в систему</h3>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Логин</label>
                        <input type="text" name="login" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Пароль</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Войти</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>