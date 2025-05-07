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
    die("غير مصرح لك.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // تشفير
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $password, $role);

    if ($stmt->execute()) {
        echo "تمت إضافة المستخدم بنجاح.";
        
        // header("Location: users.php");
    } else {
        echo "خطأ: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title >إضافة مستخدم جديد</title>
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
    
    <h1></h1>إضافة مستخدم جديد</h1>
   
    <form method="post" action="add_user.php">
        <label>اسم المستخدم:</label>
        <input type="text" name="username" required><br>
        <label>البريد الإلكتروني:</label>
        <input type="email" name="email" required><br>
        <label>كلمة المرور:</label>
        <input type="password" name="password" required><br>
        <label>الصلاحية:</label>
        <select name="role">
            <option value="admin">مدير</option>
            <option value="user">مستخدم</option>
        </select><br>
        <input type="submit" value="إضافة">
    </form>
    
    <br>
    <a href="users.php"><button>العودة إلى إدارة المستخدمين</button></a>
</body>
</html>

