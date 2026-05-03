<?php
session_start();
include '../includes/header.php';

// Перевірка, що користувач авторизований як клієнт
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
    header("Location: ../login.php");
    exit();
}
?>

<section class="client-dashboard">
    <div class="container">
        <h1 class="dashboard-title">👤 Особистий кабінет клієнта</h1>
        <p class="dashboard-welcome">Ласкаво просимо, <strong><?php echo htmlspecialchars($_SESSION['user']['username']); ?></strong>!</p>

        <nav class="client-nav">
            <a href="?section=home">🏠 Головна</a>
            <a href="?section=menu">📋 Меню</a>
            <a href="?section=order">🛒 Замовити</a>
            <a href="?section=reviews">⭐ Відгуки</a>
            <a href="../logout.php" class="btn-logout">🚪 Вийти</a>
        </nav>

        <div class="client-content">
            <?php
            $section = $_GET['section'] ?? 'home';

            if ($section == 'home') {
                echo "<p>Це ваша персональна сторінка з інформацією та доступом до функцій.</p>";
            } elseif ($section == 'menu') {
                echo "<h2>Меню</h2>";
                include 'menu_client.php';
            } elseif ($section == 'order') {
                echo "<h2>Оформлення замовлення</h2>";
                include 'order_client.php';
            } elseif ($section == 'reviews') {
                echo "<h2>Відгуки</h2>";
                include 'reviews_client.php';
            } else {
                echo "<p>Оберіть розділ у меню.</p>";
            }
            ?>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
