<?php 
session_start();
include 'inc/header.php'; 
?>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="bg-white p-5 rounded shadow-sm">
            <h1 class="mb-4">О проекте «МироТворец»</h1>
            <p class="lead">Данный веб-сервис разработан в качестве учебного проекта по дисциплине МДК 05.02 .</p>
            
            <hr class="my-4">
            
            <h3>Цель проекта</h3>
            <p>Предоставить начинающим писателям и геймдизайнерам простой инструмент для структурирования лора вымышленных вселенных.</p>
            
            <h3 class="mt-4">Технологический стек:</h3>
            <ul>
                <li><strong>Backend:</strong> PHP 8.1 (PDO для безопасной работы с БД)</li>
                <li><strong>Database:</strong> MySQL 8.0 (Связи One-to-Many между мирами и персонажами)</li>
                <li><strong>Frontend:</strong> HTML5, CSS3, Bootstrap 5</li>
                <li><strong>Инструментарий:</strong> OSPanel 6.5.1</li>
            </ul>

            <h3 class="mt-4">Реализованный функционал:</h3>
            <ol>
                <li>Регистрация и авторизация пользователей с хешированием паролей.</li>
                <li>Создание, редактирование и удаление карточек миров.</li>
                <li>Загрузка обложек для визуализации вселенных.</li>
                <li>Система создания персонажей, привязанных к конкретному миру.</li>
                <li>Публичная лента всех созданных миров.</li>
            </ol>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>