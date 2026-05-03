<?php
include '../includes/header.php'; 
session_start();
require_once '../db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

// Отримуємо меню
$sql = "SELECT * FROM menu";
$result = $conn->query($sql);
$menuItems = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Меню кав'ярні</title>
    <link rel="stylesheet" href="../style.css"> <!-- Загальний стиль -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f2ec;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            color: #5c3c1e;
            margin-bottom: 30px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .menu-item {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 16px;
            background-color: #fffaf6;
            transition: box-shadow 0.3s;
        }

        .menu-item:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .item-name {
            font-size: 18px;
            font-weight: bold;
            color: #4b2e1f;
            margin-bottom: 8px;
        }

        .item-price {
            font-size: 16px;
            color: #7a5e3a;
        }

        .btn-back {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #c57c48;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #a96536;
        }

        .no-items {
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>☕ Меню кав'ярні</h2>

    <?php if (count($menuItems) > 0): ?>
        <div class="menu-grid">
            <?php foreach ($menuItems as $item): ?>
                <div class="menu-item">
                    <div class="item-name"><?= htmlspecialchars($item['name']) ?></div>
                    <div class="item-price"><?= htmlspecialchars($item['price']) ?> грн</div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="no-items">Меню поки що порожнє.</p>
    <?php endif; ?>

    <a class="btn-back" href="dashboard.php">← Назад до панелі адміністратора</a>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>
