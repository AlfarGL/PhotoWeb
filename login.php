<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register php</title>
    <style>
        body {
            margin: 0;
            width: 100vw;
            font-size: 3vh;
        }
    </style>
</head>

<body>
    <?php
    session_start();

    // 连接数据库
    $servername = "localhost";
    $db_username = "root";
    $db_password = "19941208";
    $db_name = "photo";

    $conn = new mysqli($servername, $db_username, $db_password, $db_name);

    // 检查连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

         // 检查任意一个字段是否为空
        if (empty($username) || empty($password)) {
            $error_message = urlencode("所有字段均为必填项。");
            header("Location: index.php?error=$error_message");
            exit();
        }
        
        // 检查用户是否存在并验证密码
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            // 验证密码
            if (password_verify($password, $user['password'])) {
                // 密码正确，设置会话变量
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            } else {
                header("Location: login.html?error=密码错误");
                exit();
            }
        } else {
            header("Location: login.html?error=用户不存在");
            exit();
        }

        $stmt->close();
    }

    $conn->close();
    ?>
</body>

</html>