<?php
session_start();

require_once 'inc/db.php';

include 'inc/header.php';
?>

<div class="row align-items-center g-5 py-5">
    <div class="col-lg-6">
        <h1 class="display-5 fw-bold lh-1 mb-3">Создавайте свои миры легко</h1>
        <p class="lead">«МироТворец» — это место, где писатели могут структурировать свои идеи. Описывайте локации, продумывайте историю и храните всё в одном месте.</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <a href="register.php" class="btn btn-primary btn-lg px-4 me-md-2">Начать творить</a>
            <a href="about.php" class="btn btn-outline-secondary btn-lg px-4">О проекте</a>
        </div>
    </div>
    <div class="col-lg-6 text-center">
        <div class="bg-light border rounded-3 p-5 shadow-sm">
            <h3>🌌 Здесь рождаются легенды</h3>
            <p class="text-muted">Инструменты для лора вашего будущего романа.</p>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>