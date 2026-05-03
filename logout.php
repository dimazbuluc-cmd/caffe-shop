<?php
include 'includes/header.php'; 
session_start();
session_unset(); // Убираем все переменные сессии
session_destroy(); // Уничтожаем сессию

header("Location: login.php"); // Перенаправление на страницу входа
exit();
?>
<?php include 'includes/footer.php'; ?>