<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Список замовлень</title>
    <link rel="stylesheet" href="../style.css"> <!-- якщо є загальний стиль -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f6f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        h1 {
            text-align: center;
            color: #5c3c1e;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2e9e4;
            color: #5c3c1e;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        tr:hover {
            background-color: #f1f1f1;
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
    </style>
</head>
<body>

<div class="container">
    <h1>📦 Список замовлень</h1>

    <?php
    $orders_sql = "SELECT orders.*, users.username FROM orders LEFT JOIN users ON orders.user_id = users.id";
    $orders_result = $conn->query($orders_sql);

    if ($orders_result && $orders_result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Клієнт</th>
                    <th>Сума</th>
                    <th>Кількість</th>
                    <th>Дата</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= !empty($order['username']) ? htmlspecialchars($order['username']) : 'Невідомо' ?></td>
                        <td><?= $order['total_price'] ?> грн</td>
                        <td><?= $order['quantity'] ?></td>
                        <td><?= $order['created_at'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center;">Замовлень поки що немає.</p>
    <?php endif; ?>

    <a class="btn-back" href="dashboard.php">← Назад до панелі адміністратора</a>
</div>

</body>
</html>
<?php include '../includes/footer.php'; ?>