<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql = "INSERT INTO products_2 (name, description, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $name, $description, $price);

    if ($stmt->execute()) {
        echo "تمت إضافة المنتج بنجاح.";
      
    } else {
        echo "حدث خطأ: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إضافة منتج جديد</title>
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
    <h1  style="text-align:center;">إضافة منتج جديد</h1>
    <form method="post" action="add_product.php">
        <label>اسم المنتج:</label>
        <input type="text" name="name" required><br>
        <label>الوصف:</label>
        <textarea name="description"></textarea><br>
        <label>السعر:</label>
        <input type="number" step="0.01" name="price" required><br>
        <input type="submit" value="إضافة">
    </form>
    <br>

    <a href="products.php"><button>العودة إلى إدارة المنتجات</button></a>
</body>
</html>
