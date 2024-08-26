<!DOCTYPE html>
<html lang="en">

<head>
    <style type="text/css">
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        div {
            padding: 0px;
            margin: 0px;
            position: relative; /* 确保删除按钮在容器内绝对定位 */
        }

        img {
            max-width: 100%; /* 使用视窗的短边作为图片的最大宽度 */
            max-height: 100%; 
            image-orientation: from-image;
        }

        /* 删除按钮样式 */
        .delete-button {
            position: absolute; /* 使用绝对定位 */
            bottom: 10px; /* 距离底部 10px */
            right: 10px; /* 距离右侧 10px */
            padding: 5px 10px;
            background-color: rgba(255, 0, 0, 0);
            color: white;
            border: none;
            cursor: pointer;
            font-size: 12px; /* 默认字体大小 */
        }

        /* 鼠标悬停样式 */
        .delete-button:hover {
            background-color: rgba(139, 0, 0, 0.5);
        }

        /* 大屏幕设备（如桌面端）样式 */
        @media (min-width: 768px) {
            .delete-button {
                font-size: 76px; /* 增大字体大小 */
                padding: 10px 20px; /* 增大内边距 */
            }
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Screen Image</title>
</head>

<body>
    <div>
        <?php
        // 获取图片地址参数
        $image_path = isset($_GET['image']) ? $_GET['image'] : '';

        $new_image_path = '4K/' . substr(basename($image_path), 1);
        // 显示图片
        if (!empty($image_path)) {
            echo '<img src="' . $new_image_path . '" alt="Full Screen Image"  id="fullscreen-image"/>';
        } else {
            echo '<p>No image found.</p>';
        }
        ?>
        <button class="delete-button" onclick="deleteImage()">Delete Image</button>
        <script>
        // 删除图片函数
        function deleteImage() {
            var image_path = '<?php echo $image_path; ?>'; // 获取图片路径
            var new_image_path = '<?php echo $new_image_path; ?>';
            // 发送 AJAX 请求或者跳转到服务器端脚本以删除图片
            // 这里只是一个示例，你需要根据实际情况进行修改
            if (confirm("Are you sure you want to delete this image?")) {
                // 用户确认删除，可以执行删除操作
                // 发送 AJAX 请求删除图片
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_image.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4) {
                        console.log(xhr.responseText);
                        if (xhr.status == 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.status === 'success') {
                                alert(response.message);
                                //window.location.href = "index.php";
                                window.close();
                            } else {
                                alert("Error: " + response.message);
                            }
                        } else {
                            alert("Request failed. Status: " + xhr.status);
                        }
                    }
                };
                xhr.send("image1=" + encodeURIComponent(image_path) + "&image2=" + encodeURIComponent(new_image_path));
            } else {
                // 用户取消删除，不执行任何操作
            }
        }
        // 获取视口的宽度和高度
        var viewportWidth = window.innerWidth || document.documentElement.clientWidth;
        var viewportHeight = window.innerHeight || document.documentElement.clientHeight;

        // 获取图片元素
        var img = document.getElementById("fullscreen-image");

        // 计算图片的宽度和高度
        var imgWidth, imgHeight;
        if (viewportWidth < viewportHeight) {
            // 视口的宽度小于高度，使用视口的宽度作为图片的宽度
            imgWidth = "100vw";
            imgHeight = "auto"; // 自动调整高度
        } else {
            // 视口的宽度大于等于高度，使用视口的高度作为图片的高度
            imgWidth = "auto"; // 自动调整宽度
            imgHeight = "100vh";
        }

        // 设置图片的宽度和高度
        img.style.width = imgWidth;
        img.style.height = imgHeight;
        </script>
    </div>
</body>

</html>