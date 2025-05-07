<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

session_start();


if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
   
}


$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستخدمين</title>

    <style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }
    th {
        background-color: #f4f4f4;
    }
       
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
</style>
</head>
<body>
    <h1>إدارة المستخدمين</h1>

  
    <a href="add_user.php"><button>إضافة مستخدم جديد</button></a>

    <table>
        <thead>
            <tr>
                <th>اسم المستخدم</th>
                <th>البريد الإلكتروني</th>
                <th>الصلاحية</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php
             
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['role'] . "</td>";
                echo "<td>
                        <a href='edit_user.php?id=" . $row['id'] . "'>تعديل</a>  
                        <a href='delete_user.php?id=" . $row['id'] . "'>حذف</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>

<?php

$conn->close();
?>