<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}


$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


$sql = "SELECT * FROM products_1 WHERE id = $product_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if (!$product) {
    echo "المنتج غير موجود.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تفاصيل المنتج</title>
    <style>
        body {
            font-family: Arial, Tahoma;
            background-color: #f8f8f8;
            padding: 20px;
        }

        .product-detail {
            max-width: 800px;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
        }

        .product-detail img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 6px;
        }

        .product-detail h2 {
            margin: 20px 0;
        }

        .product-detail p {
            color: #444;
            font-size: 16px;
            margin: 10px 0;
        }

        .product-detail .price {
            color: #2ecc71;
            font-weight: bold;
            font-size: 20px;
        }

        .label {
            font-weight: bold;
            color: #333;
        }
        .back-button {
    background-color: #4CAF50; 
    color: white; 
    padding: 10px 20px; 
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 5px; 
    cursor: pointer;
    transition: background-color 0.3s;
}

.back-button:hover {
    background-color:rgb(60, 138, 63); 
}

    </style>
</head>
<body>

<div class="product-detail">
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>

    <?php if (!empty($product['image'])): ?>
        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="صورة المنتج">
    <?php else: ?>
        <img src="img" alt=" descktoop img" >
    <?php endif; ?>

    <p><span class="label">الوصف:</span> <?php echo htmlspecialchars($product['description']); ?></p>
    <p class="price"><?php echo number_format($product['price'], 2); ?>$</p>

    <p><span class="label">الماركة:</span> <?php echo htmlspecialchars($product['brand']); ?></p>
    <p><span class="label">المخزون:</span> <?php echo htmlspecialchars($product['stock']); ?></p>
    <p><span class="label">الضمان:</span> <?php echo htmlspecialchars($product['warranty']); ?></p>
    <p><span class="label">اللون:</span> <?php echo htmlspecialchars($product['color']); ?></p>
    <p><span class="label">الحجم:</span> <?php echo htmlspecialchars($product['size']); ?></p>
    <p><span class="label">تفاصيل إضافية:</span> <?php echo nl2br(htmlspecialchars($product['extra_details'])); ?></p>
</div>

<a href="index.php">
    <button class="back-button">العودة إلى الصفحة الرئيسية</button>
</a>

</body>
</html>

<?php $conn->close(); ?>
