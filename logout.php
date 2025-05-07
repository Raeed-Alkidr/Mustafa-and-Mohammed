<?php
session_start();
session_destroy();       


if (!isset($_SESSION["user_id"])) {
   
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم</title>
    <style>
        body {
            font-family: Tahoma, Arial;
            background-color: #f0f0f0;
            text-align: center;
            padding-top: 100px;
        }

        .container {
            background-color: white;
            padding: 40px;
            margin: auto;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
        }

        h1 {
            color: #333;
        }

        a.logout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a.logout:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>مرحبًا، <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
        <p>أنت الآن في لوحة التحكم الخاصة بك</p>
        <a class="logout" href="logout.php">تسجيل الخروج</a>
    </div>
</body>
</html>
