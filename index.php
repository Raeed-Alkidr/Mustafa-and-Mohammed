<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}


$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>قائمة المنتجات</title>
    <style>
    
        body {
            font-family: Arial, Tahoma;
            background-color:#A7B49E;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .products {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    justify-items: center;
}


        .product {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            width: 250px;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
        }

        .product img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 6px;
            transition: transform 0.3s ease-in-out;
        }
        .product img:hover {
    transform: scale(1.1); 
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}


        .product h3 {
            margin: 10px 0 5px;
        }

        .product p {
            color: #666;
            font-size: 14px;
        }

        .product .price {
            color: #2ecc71;
            font-weight: bold;
        }
    </style>
    
</head>
<body>

<h1>قائمة المنتجات</h1>

<div class="products">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product">
                <?php if (!empty($row["image"])): ?>
                    <img src="<?php echo htmlspecialchars($row["image"]); ?>" alt="صورة المنتج">
                <?php else: ?>
                    <img src="img_3.jpeg" alt="descktop img">
                <?php endif; ?>
                
                <h3><?php echo htmlspecialchars($row["product_name"]); ?></h3>
                <p><?php echo htmlspecialchars($row["description"]); ?></p>
                <p class="price"><?php echo number_format($row["price"], 2); ?>$</p>
                
               
                <a href="product_1.php?id=<?php echo $row['id']; ?>" class="btn-details">تفاصيل المنتج</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>لا توجد منتجات حاليًا.</p>
    <?php endif; ?>
</div>


<div class="products">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product">
                <?php if (!empty($row["image"])): ?>
                    <img src="<?php echo htmlspecialchars($row["image"]); ?>" alt="صورة المنتج">
                <?php else: ?>
                    <img src="img_3.jpeg" alt="descktop img">
                <?php endif; ?>
                
                <h3><?php echo htmlspecialchars($row["product_name"]); ?></h3>
                <p><?php echo htmlspecialchars($row["description"]); ?></p>
                <p class="price"><?php echo number_format($row["price"], 2); ?>$</p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>لا توجد منتجات حاليًا.</p>
    <?php endif; ?>
</div>

<?php $conn->close(); ?>

</body>
</html>
