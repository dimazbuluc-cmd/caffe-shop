<?php
include '../includes/header.php';
session_start();

// Перевірка авторизації
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель адміністратора - Кав'ярня</title>
    <link rel="stylesheet" href="../style.css"> <!-- Підключаємо головний стиль -->
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1 class="admin-title">☕ Aroma Coffee — Адмін Панель</h1>
            <nav class="admin-nav">
                <a href="dashboard.php">🏠 Головна</a>
                <a href="employees.php">👥 Працівники</a>
                <a href="orders.php">🧾 Замовлення</a>
                <a href="menu.php">📋 Меню</a>
                <a href="reports.php">📊 Звіти</a>
                <a href="../logout.php" class="btn-logout">🚪 Вийти</a>
            </nav>
        </div>
    </header>

    <main class="admin-main">
        <div class="container">
            <h2>👋 Вітаємо, <span class="username"><?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>!</h2>
            <p>Оберіть розділ у меню зверху для керування кав’ярнею.</p>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
