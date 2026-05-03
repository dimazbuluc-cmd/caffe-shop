<?php

// Подключение к базе данных
require_once '../db.php';

// Получаем меню из базы данных
$menu_result = $conn->query("SELECT * FROM menu");

if ($menu_result->num_rows > 0) {
    echo "<table>";
    echo "<thead><tr><th>Назва</th><th>Ціна</th></tr></thead>";
    echo "<tbody>";
    while ($item = $menu_result->fetch_assoc()) {
        echo "<tr><td>{$item['name']}</td><td>{$item['price']} грн</td></tr>";
    }
    echo "</tbody></table>";
} else {
    echo "Меню пусте.";
}
?>
