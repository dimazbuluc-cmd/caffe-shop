<?php
include '../includes/header.php';
session_start();
require_once '../db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT username, position FROM users WHERE role = 'employee'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Список працівників</title>
    <link rel="stylesheet" href="../style.css"> <!-- підключення основного стилю -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f6f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
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
            padding: 16px;
            text-align: left;
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

        .button-back {
            display: inline-block;
            margin-top: 30px;
            text-decoration: none;
            background-color: #c57c48;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .button-back:hover {
            background-color: #a96536;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>👥 Список працівників</h1>

    <table>
        <tr>
            <th>Ім’я користувача</th>
            <th>Посада</th>
        </tr>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['position']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">Працівників поки немає.</td>
            </tr>
        <?php endif; ?>
    </table>

    <a class="button-back" href="dashboard.php">← Назад до панелі адміністратора</a>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>
