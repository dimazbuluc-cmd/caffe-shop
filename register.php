<?php
include 'includes/header.php'; 
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Підготовлений запит для безпеки
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'client')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
    
    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Помилка при реєстрації!";
    }
}
?>

<section class="login-section">
    <div class="login-container">
        <h2 class="login-title">📝 Реєстрація</h2>

        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="" class="login-form">
            <div class="form-group">
                <label for="username">Логін:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn-submit">Зареєструватися</button>
            </div>
        </form>

        <p class="register-link">Вже маєте акаунт? <a href="login.php">Увійти</a></p>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
