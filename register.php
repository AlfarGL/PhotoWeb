<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    
    // 检查任意一个字段是否为空
    if (empty($username) || empty($password) || empty($email)) {
        $error_message = urlencode("所有字段均为必填项。");
        header("Location: index.php?error=$error_message");
        exit();
    }
    
    // 运行 Python 脚本并传递参数
    $python_script = 'register.py'; // 替换为您的 Python 脚本路径
    $command = escapeshellcmd("python3 $python_script " . escapeshellarg($username) . " " . escapeshellarg($password) . " " . escapeshellarg($email));

    // 执行命令
    $output = shell_exec($command);

    // 对输出进行编码以便在URL中使用
    $encoded_output = urlencode($output);

    // 输出 Python 脚本的返回结果
    header("Location: register.html?error=$encoded_output");
    exit();
}
?>