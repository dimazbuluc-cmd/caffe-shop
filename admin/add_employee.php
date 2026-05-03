<?php
include '../includes/header.php';
session_start();
require_once '../db.php';

// Перевірка, що користувач адмін
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$success = "";
$error = "";

// Якщо форма була відправлена
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $position = trim($_POST['position']);

    if (!empty($username) && !empty($password) && !empty($position)) {
        // Перевірка, чи існує такий користувач
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $error = "Користувач з таким ім'ям вже існує.";
        } else {
            // Хешуємо пароль
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // Додаємо нового працівника з посадою
            $stmt = $conn->prepare("INSERT INTO users (username, password, role, position) VALUES (?, ?, 'employee', ?)");
            $stmt->bind_param("sss", $username, $password_hashed, $position);

            if ($stmt->execute()) {
                $success = "Працівника успішно додано!";
            } else {
                $error = "Помилка при додаванні працівника.";
            }
            $stmt->close();
        }

        $check_stmt->close();
    } else {
        $error = "Будь ласка, заповніть всі поля.";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Додати працівника</title>
    <style>
        body {
            font-family: sans-serif;
            max-width: 500px;
            margin: 40px auto;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 6px;
        }
        .error {
            background-color: #ffdede;
            color: #b10000;
        }
        .success {
            background-color: #e0ffe0;
            color: #007500;
        }
    </style>
</head>
<body>

<h1>Додати нового працівника</h1>

<?php if (!empty($error)): ?>
    <div class="message error"><?= $error ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="message success"><?= $success ?></div>
<?php endif; ?>

<form method="post" action="">
    <label>Ім'я користувача:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Пароль:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Посада:</label><br>
    <select name="position" required>
        <option value="">-- Виберіть посаду --</option>
        <option value="Бариста">Бариста</option>
        <option value="Офіціант">Офіціант</option>
        <option value="Кухар">Кухар</option>
        <option value="Менеджер">Менеджер</option>
    </select><br><br>

    <button type="submit">Додати працівника</button>
</form>

<br>
<a href="employees.php">← Назад до списку працівників</a>

</body>
</html>
<?php include '../includes/footer.php'; ?>
