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

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
} else {
    echo "معرف المستخدم غير صحيح.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تعديل المستخدم</title>

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
    <h1>تعديل بيانات المستخدم</h1>
    <form action="update_user.php" method="post">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <label>اسم المستخدم:</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>"><br>
        <label>البريد الإلكتروني:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>"><br>
        <label>الصلاحية:</label>
        <select name="role">
            <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>مدير</option>
            <option value="user" <?php if($user['role']=='user') echo 'selected'; ?>>مستخدم</option>
        </select><br>
        <input type="submit" value="حفظ التعديلات">
    </form>
    <br>
    <a href="users.php"><button>العودة إلى إدارة المستخدمين</button></a>
</body>
</html>
