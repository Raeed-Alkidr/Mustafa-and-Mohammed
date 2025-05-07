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


if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("غير مصرح لك بالوصول.");
}


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

   
    $query = "DELETE FROM users WHERE id = $id";
    if ($conn->query($query) === TRUE) {
        
        echo "<p>تم حذف المستخدم بنجاح.</p>";
    } else {
        echo "حدث خطأ أثناء الحذف: " . $conn->error;
    }
} else {
    echo "معرف المستخدم غير موجود.";
}


$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>delete </title>
    <style>
       
        button {
            padding: 10px 20px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

       
        button:hover {
            background-color: #0b7dda;
        }
    </style>
</head>
<body>
    <h1>العنصر أصبح غير موجود</h1>
</body>
</html>

<a href="users.php"><button>العودة إلى إدارة المستخدمين</button></a>