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


$stmt = $conn->prepare("DELETE FROM products_2 WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location:products.php?deleted=1");
    exit;
} else {
    echo "حدث خطأ أثناء حذف المنتج: " . $stmt->error;
}

$conn->close();
?>



