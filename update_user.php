<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

session_start();


// if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
//     die("غير مصرح لك.");
// }


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET username=?, email=?, role=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $email, $role, $id);

    if ($stmt->execute()) {
        echo "تم تعديل المستخدم بنجاح.";
        
        // header("Location: users.php");
    } else {
        echo "خطأ في التعديل: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
