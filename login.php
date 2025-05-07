<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$error = "";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password =$_POST["password"];

    if (empty($email) || empty($password)) {
        $error = "جميع الحقول مطلوبة.";
    } else {
        
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $username, $hashed_password, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password))
             {
                $_SESSION["user_id"] = $id;
                $_SESSION["username"] = $username;
                $_SESSION["role"] = $role; 

               
                if ($role == '') {
                    header("Location: users.php"); 
                } else {
                    header("Location: logout.php"); 
                }
                exit;
            }
             else {
                $error = "كلمة المرور غير صحيحة.";
            }
        } else {
            $error = "لا يوجد حساب بهذا البريد الإلكتروني.";
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
    <title>تسجيل الدخول</title>
    <style>
    body {
        font-family: Tahoma, Arial;
        background-color: #f7f7f7;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .form-container {
        background-color: #fff;
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
        background-color: #2196F3;
        color: white;
        border: none;
        padding: 12px;
        width: 100%;
        border-radius: 6px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color:rgb(4, 48, 84);
    }

    .error {
        color: red;
        text-align: center;
        margin-bottom: 15px;
        font-weight: bold;
    }
</style>

</head>
<body>
<div class="form-container">
    <h2>تسجيل الدخول</h2>

    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" action="">
        <label>البريد الإلكتروني:</label>
        <input type="email" name="email">

        <label>كلمة المرور:</label>
        <input type="password" name="password">

        <input type="submit" value="دخول">
    </form>
</div>

<a href="index.php"></a>
</body>
</html>

