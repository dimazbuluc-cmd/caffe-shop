<?php
// session_start(); — НЕ ПИШИ тут! Сесія вже запущена в dashboard_client.php

// Перевірка авторизації
if (!isset($_SESSION['user']['id'])) {
    echo "Користувач не авторизований.";
    exit;
}

// Підключення до бази даних
require_once '../db.php';

// Отримуємо ID користувача
$user_id = (int)$_SESSION['user']['id'];

// Перевірка відправки форми
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['review'])) {
    $review = $conn->real_escape_string($_POST['review']);

    // Додаємо відгук у таблицю reviews (в поле content)
    $conn->query("INSERT INTO reviews (user_id, content) VALUES ($user_id, '$review')");

    // Відразу оновити сторінку без перекидання
    echo "<p style='color: green;'>✅ Відгук успішно додано!</p>";
}

// Отримуємо всі відгуки поточного користувача
$reviews_result = $conn->query("SELECT * FROM reviews WHERE user_id = $user_id");
?>

<h3>Залишити відгук</h3>
<form action="?section=reviews" method="post">
    <textarea name="review" placeholder="Ваш відгук" required></textarea>
    <br>
    <button type="submit">Залишити відгук</button>
</form>

<h3>Ваші відгуки</h3>
<?php
if ($reviews_result && $reviews_result->num_rows > 0) {
    while ($review = $reviews_result->fetch_assoc()) {
        echo "<p>" . htmlspecialchars($review['content']) . "</p>";
    }
} else {
    echo "<p>Ви ще не залишали відгуки.</p>";
}
?>
