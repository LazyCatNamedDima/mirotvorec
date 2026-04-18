<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>МироТворец</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; color: #6f42c1 !important; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">МироТворец</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Главная</a></li>
                <li class="nav-item"><a class="nav-link" href="worlds.php">Все миры</a></li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link fw-bold text-info" href="profile.php">Мои миры (<?= $_SESSION['user_login'] ?>)</a></li>
                    
                    <li class="nav-item"><a class="nav-link btn btn-outline-primary btn-sm mx-2 text-white" href="create.php">+ Создать мир</a></li>

                    <li class="nav-item"><a class="nav-link btn btn-outline-primary btn-sm mx-2 text-white" href="settings.php">Настройки</a></li>
                    
                    <li class="nav-item"><a class="nav-link" href="logout.php">Выход</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Вход</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Регистрация</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container">