<?php
include 'includes/header.php'; 
session_start();
require_once 'db.php'; // db.php знаходиться в тій же папці

// Перевірка POST-запиту
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Екраніруємо введення
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Запит до бази даних
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($user['password'] == $password) {
            // Зберігаємо в сесії
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
            ];

            // Перенаправлення за роллю
            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: client/dashboard_client.php");
            }
            exit();
        } else {
            $error_message = "Невірний логін або пароль.";
        }
    } else {
        $error_message = "Користувача не знайдено.";
    }
}
?>

<section class="login-section">
    <div class="login-container">
        <h2 class="login-title">🔐 Вхід на сайт</h2>

        <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST" class="login-form">
            <div class="form-group">
                <label for="username">Логін:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn-submit">Увійти</button>
            </div>
        </form>

        <p class="register-link">Ще не зареєстровані? <a href="register.php">Зареєструватися</a></p>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
