<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}


if (
    isset($_POST['id']) &&
    isset($_POST['name']) &&
    isset($_POST['description']) &&
    isset($_POST['price'])
) {
    $id = intval($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $price = floatval($_POST['price']);

   
    $stmt = $conn->prepare("UPDATE products_2 SET name=?, description=?, price=? WHERE id=?");
    $stmt->bind_param("ssdi", $name, $description, $price, $id);

    if ($stmt->execute()) {
        header("Location: products.php?updated=1");
        exit;
    } else {
        echo "حدث خطأ أثناء تحديث المنتج: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "بيانات غير مكتملة.";
}

$conn->close();
?>
