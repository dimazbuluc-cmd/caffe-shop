<?php 
session_start();
include 'includes/header.php'; 
?> 

<section class="welcome-section">
    <div class="welcome-container">
        <h1 class="welcome-title">Ласкаво просимо до <span class="brand-name">Aroma Coffee</span> ☕</h1>

        <p class="welcome-text">
            У нас найсмачніша кава в місті! Обирай з меню, залишай відгуки або приєднуйся до нашої команди ❤️
        </p>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="welcome-buttons">
                <a href="login.php" class="btn-primary">Увійти</a>
                <a href="register.php" class="btn-secondary">Зареєструватися</a>
            </div>
        <?php else: ?>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <p class="welcome-text">🔐 Ви увійшли як <strong>адміністратор</strong>.</p>
                <a href="admin/dashboard.php" class="btn-primary">Перейти в панель керування</a>
            <?php else: ?>
                <p class="welcome-text">☕ Готові зробити замовлення?</p>
                <a href="client/menu_client.php" class="btn-primary">До меню</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
