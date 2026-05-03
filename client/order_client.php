<?php


if (!isset($_SESSION['user']['id'])) {
    echo "Користувач не авторизований.";
    exit;
}

require_once '../db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_item_id = (int)$_POST['menu_item'];
    $quantity = (int)$_POST['quantity'];

    $query = "SELECT price FROM menu WHERE id = $menu_item_id";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $item = $result->fetch_assoc();
        $price = (float)$item['price'];
        $total_price = $price * $quantity;

        $user_id = (int)$_SESSION['user']['id'];
        $conn->query("INSERT INTO orders (user_id, menu_item_id, quantity, total_price)
                      VALUES ($user_id, $menu_item_id, $quantity, $total_price)");

        $message = "<p style='color:green;'>✅ Замовлення оформлено!</p>";
    } else {
        $message = "<p style='color:red;'>❌ Товар не знайдено.</p>";
    }
}
?>

<!-- Повідомлення -->
<?= $message ?>

<!-- Форма замовлення -->
<form method="post">
    <select name="menu_item" required>
        <option value="">Оберіть товар</option>
        <?php
        $menu_items = $conn->query("SELECT * FROM menu");
        while ($item = $menu_items->fetch_assoc()) {
            echo "<option value=\"{$item['id']}\">{$item['name']} - {$item['price']} грн</option>";
        }
        ?>
    </select>
    <input type="number" name="quantity" placeholder="Кількість" required min="1">
    <button type="submit">Оформити замовлення</button>
</form>
