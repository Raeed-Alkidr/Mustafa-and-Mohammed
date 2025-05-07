<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$success = "";
$error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

   
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "جميع الحقول مطلوبة.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "صيغة البريد الإلكتروني غير صحيحة.";
    } elseif ($password !== $confirm_password) {
        $error = "كلمة المرور وتأكيدها غير متطابقين.";
    } 
 elseif (strlen($password) < 6) {
    $error = "يجب أن تكون كلمة المرور 6 أحرف أو أكثر.";
}
    else {
     
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "هذا البريد مستخدم بالفعل.";
        } else {
           
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $success = "تم التسجيل بنجاح! يمكنك الآن تسجيل الدخول";
            } else {
                $error = "حدث خطأ أثناء التسجيل.";
            }
        }
        $stmt->close();
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل مستخدم جديد</title>

    <style>
        body {
            font-family: Tahoma, Arial;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
            width: 350px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
    
</head>
<body>
<div class="form-container">
    <h2>تسجيل حساب جديد</h2>

    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

    <form method="POST" action="">
        <label>اسم المستخدم:</label><br>
        <input type="text" name="username"><br><br>

        <label>البريد الإلكتروني:</label><br>
        <input type="email" name="email"><br><br>

        <label>كلمة المرور:</label><br>
        <input type="password" name="password"><br><br>

        <label>تأكيد كلمة المرور:</label><br>
        <input type="password" name="confirm_password"><br><br>

        <input type="submit" value="تسجيل">
    </form>
    </div>
</body>
</html>
