<?php
session_start();
require_once '../db.php';
include '../includes/header.php'; 

// Перевірка прав доступу
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Отримання звітів
$sql = "SELECT COUNT(id) AS total_orders, SUM(total_price) AS total_revenue FROM orders";
$result = $conn->query($sql);
$report = ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Звіти про замовлення</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f5f1;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 60px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            color: #5e412f;
            margin-bottom: 30px;
        }

        .report-data {
            font-size: 18px;
            color: #3e2c1c;
            margin-bottom: 15px;
        }

        .btn-back {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 18px;
            background-color: #b67140;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #9e5c31;
        }

        .no-data {
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📈 Звіти про замовлення</h2>

    <?php if ($report): ?>
        <div class="report-data">🔢 Кількість замовлень: <strong><?= htmlspecialchars($report['total_orders']) ?></strong></div>
        <div class="report-data">💰 Загальний дохід: <strong><?= htmlspecialchars($report['total_revenue']) ?> грн</strong></div>
    <?php else: ?>
        <p class="no-data">Немає даних для звітів.</p>
    <?php endif; ?>

    <a class="btn-back" href="dashboard.php">← Назад до панелі адміністратора</a>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>
