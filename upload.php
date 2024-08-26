<?php
// 指定文件上传目录
$upload_dir = '/var/www/html/4K/';

// 如果文件夹不存在，则创建
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// 处理上传的图片文件
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];

    // 获取文件名和扩展名，并进行规范化处理
    $filename = preg_replace("/[^a-zA-Z0-9\-\_\.]/", '', $file['name']); // 删除文件名中的特殊字符

    // 移动文件到上传目录
    $target_path = $upload_dir . $filename;
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        // 文件上传成功，调用 Python 脚本并传递文件路径参数
        $python_script = 'imageZ.py';
        $filepath = realpath($target_path); // 获取文件的绝对路径
        $command = "python3 $python_script \"$filepath\"";
        exec($command, $output, $return_code);

        // 输出 Python 脚本的执行结果
        echo "<script>alert('";
        if ($output === null) {
            echo "Failed to execute Python script.";
        } else {
            foreach ($output as $line) {
                echo "$line \\n";
            }
        }
        echo "'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Failed to upload image.'); window.location.href = 'index.php';</script>";
    }
}
?>
