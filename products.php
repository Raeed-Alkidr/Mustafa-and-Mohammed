<?php
session_start();



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$sql = "SELECT * FROM products_2";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة المنتجات</title>
    <style>
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        .add-btn {
            margin: 20px auto;
            display: block;
            width: fit-content;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .add-btn:hover {
            background-color: #45a049;
        }
        .action-links a {
            margin: 0 5px;
            color: #2196F3;
            text-decoration: none;
        }
        .action-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>


<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
    <h2 style="text-align:center; color: green;">تم حذف المنتج بنجاح</h2>
<?php endif; ?>

    <h1 style="text-align:center;">إدارة المنتجات</h1>
    <a class="add-btn" href="add_product.php"> إضافة منتج جديد</a>

    <table>
        <tr>
            <th>المعرف</th>
            <th>اسم المنتج</th>
            <th>الوصف</th>
            <th>السعر</th>
            <th>العمليات</th>
            
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['description'] ?></td>
            <td><?= $row['price'] ?> $</td>
            <td class="action-links">
                <a href="edit_product.php?id=<?= $row['id'] ?>">تعديل</a>
                <a href="delete_product.php?id=<?= $row['id'] ?>">حذف</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
