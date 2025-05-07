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


if (!isset($_GET['id'])) {
    die("معرف المنتج غير موجود.");
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = floatval($_POST['price']);

    $stmt = $conn->prepare("UPDATE products_2 SET name=?, description=?, price=? WHERE id=?");
    $stmt->bind_param("ssdi", $name, $description, $price, $id);

    if ($stmt->execute()) {
        header("Location:products.php");
        exit;
    } else {
        echo "حدث خطأ أثناء التحديث: " . $stmt->error;
    }
}


$stmt = $conn->prepare("SELECT * FROM products_2 WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("المنتج غير موجود.");
}
?>
<?php $conn->close(); ?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تعديل المنتج</title>
    <style>
        form {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        label, input, textarea {
            display: block;
            width: 100%;
            margin-bottom: 15px;
        }
        input, textarea {
            padding: 10px;
        }
        button {
            padding: 10px 20px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #0b7dda;
        }
    </style>
</head>
<body>

    <h1 style="text-align:center;">تعديل المنتج</h1>
    <form method="post">
        <label>اسم المنتج:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

        <label>الوصف:</label>
        <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>

        <label>السعر:</label>
        <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
<br>
        <button type="submit"> حفظ التغييرات</button>
    </form>
    <br>
    <a href="products.php"><button>العودة إلى إدارة المنتجات</button></a>

</body>
</html>


