<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChaoChao & YangYuan</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 0;
            background:rgb(255,255,255,255);
        }

        .column {
            width: calc(33.33% - 2px);
            /* 计算每列的宽度，考虑到间隔的影响 */
            float: left;
            /* 使用 float 让列元素水平排列 */
            box-sizing: border-box;
            /* 让 padding 和 border 不会影响元素的实际宽度 */
            padding: 2px 0;
            /* 添加顶部和底部 2px 的内边距 */
            text-align: center;
            margin-right: 2px;
            /* 添加右侧 2px 的间隔 */
        }

        .column:last-child {
            margin-right: 0;
            /* 最后一列取消右侧间隔 */
        }

        .column a {
            display: block;
            /* 让链接占据整个父容器的空间 */
            text-decoration: none;
            /* 取消下划线 */
        }

        .column img {
            width: 100%;
            height: auto;
            display: block;
            /* 让图片在容器中居中显示 */
            margin: 2px 0;
            /* 设置图片上下间距为 20px */
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }


        .file-upload {
            font-family: "黑体", "SimHei", sans-serif;
            position: relative;
            overflow: hidden;
            display: inline-block;
            align-items: center;
        }

        .file-upload input[type="file"] {
            font-size: 2vh;
            position: absolute;
            left:0;
            top: 0;
            opacity: 0;
        }

        .file-upload .custom-file-upload {
            font-size: 2vh;
            margin: 0px;
            padding: 0px 0px;
            color: rgba(0,0,0,0, 1);
            background: rgba(255, 255, 255, 0);
            border: 0px solid #ffffff;
            cursor: pointer;
            align-items: center;
        }

        .file-upload .custom-file-upload2 {
            font-size: 2vh;
            margin: 0px;
            padding: 0px 0px;
            color: rgba(0,0,0, 0);
            background: rgba(255, 255, 255,0);
            border: 0px solid #ffffff;
            cursor: pointer;
        }

        button {
            font-family: "黑体", "SimHei", sans-serif;
            font-size: 2vh;
            margin: 0px;
            padding: 0px 0px;
            color: rgba(0,0,0, 1);
            background: rgba(255, 255, 255,0);
            border: 1px solid #000000;
            padding: 0px 2vw;
            cursor: pointer;
        }

        form {
            width: 100%;
            height: 8vh;
            display: flex;
            align-items: center;
            justify-content: right;
            background: linear-gradient(to bottom, #ffffff, #ffffff);
            color: #000000;
        }

        .prec {
            background: linear-gradient(to bottom, #555555, #000000);
            /* 深灰色到黑色的渐变背景 */
            color: #888888;
            /* 字体颜色为白色 */
            width: 100%;
            padding: 0px;
            text-align: left;

        }
        .prec h1 {
            color: #FFFFFF;
            text-align: left;
            font-size: 3vh;
            margin: 0;
        }
        .prec h2 {
            font-family: "SimSun", "STSong", serif;
            text-align: left;
            font-size: 2vh;
            margin:0;
        }
        .prec h9 {
            font-size: 1.5vh;
            margin:0;
            color: rgba(0, 0, 0, 0); 
        }


        .prec a {
            width: 25%;
            font-size: 2vh;
            color: #ffffff;
            /* 链接文字颜色为白色 */
            text-decoration: none;
            /* 取消下划线 */
            margin: 0 10px;
            /* 添加左右边距 */
            display: inline-block;
        }

        .prec a:hover {
            text-decoration: underline;
            /* 鼠标悬停时下划线效果 */
        }

        .fimg {
            width: 100vw;
            margin: 0px 0px 4vh;
        }

        .slogen {
            width: 100vw;
            margin: 0px 0px 4vh;
            font-family: "黑体", "SimHei", sans-serif;
            font-size: 4vh;
            font-weight: bold;
            color:black;
            text-align: center; /* 让文本居中显示 */
        }

        /* 样式可以根据你的需要进一步修改 */
        .button-container {
            display: flex;
            justify-content: flex-end; /* 将项目靠右对齐 */
            width:100%;
            font-size: 4vh;
            text-align: left;
            margin-top: 20px;
        }


        .button-container a {
            text-decoration: none;
            margin: 0 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: 1px solid #007bff;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .button-container a:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        
        /* 小屏幕设备（如桌面端）样式 */
        @media (max-width: 768px) {

            .file-upload input[type="file"] {
                font-size: 2vh;
            }
            .file-upload .custom-file-upload {
                font-size: 2vh;
            }
            .file-upload .custom-file-upload2 {
                font-size: 0.4vh;
            }
            button {
                font-size: 2vh;
            }
            .fimg {
                margin: 0px 0px 2vh;
            }
        }

    </style>
</head>

<body>
    <?php if (!isset($_SESSION['username'])) : ?>
        <div class="button-container">
            <a href="login.html">登录</a>
            <a href="register.html">注册</a>
        </div>
    <?php endif; ?>
    
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="file-upload">
                <label class="custom-file-upload">
                    <span id="file-upload-label">选择照片</span>
                    <input type="file" name="image" accept="image/*" onchange="updateFileName(this)">
                </label>
                <label class="custom-file-upload2"> hh </label>
            </div>
            <button type="submit">上传</button>
            <div class="file-upload">
                <label class="custom-file-upload2"> hhhhhhhhhhhhh </label>
            </div>
        </form>

    <img class="fimg" src="back.png" alt="back.png">
    <div class="slogen">是什么让我们爱如潮水</div>
    <script>
        function updateFileName(input) {
            const label = document.getElementById('file-upload-label');
            if (input.files && input.files.length > 0) {
                label.textContent = input.files[0].name;
                label.style.color = 'lightgray'; // 改变字体颜色为浅灰色
            } else {
                label.textContent = 'Select File';
                label.style.color = 'black'; // 改变字体颜色为默认颜色
            } 
        }
    </script>
        <?php
        // 指定图片文件夹
        $image_folder = 'zip';

        // 支持的图片扩展名
        $allowed_extensions = array('png', 'jpg', 'jpeg', 'gif', 'avif');

        // 扫描文件夹并获取所有文件
        $image_files = scandir($image_folder);

        // 初始化数组来存储图片文件路径、修改日期和文件名
        $image_details = array();

        // 遍历文件夹中的文件并存储图片文件路径、修改日期和文件名
        foreach ($image_files as $file) {
            $file_extension = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array(strtolower($file_extension), $allowed_extensions)) {
                $image_path = $image_folder . '/' . $file;
                $modified_time = filemtime($image_path); // 获取文件的修改时间
                // 获取图片尺寸
                // 使用 exif_read_data 获取图片尺寸
                $exif_data = exif_read_data($image_path);
                if ($exif_data !== false) {
                    $image_width = $exif_data['COMPUTED']['Width'];
                    $image_height = $exif_data['COMPUTED']['Height'];
                    $orientation = isset($exif_data['Orientation']) ? $exif_data['Orientation'] : 1;
                } else {
                    // 如果 exif_read_data 失败，则使用 getimagesize 作为备选方案
                    $image_size = getimagesize($image_path);
                    $image_width = $image_size[0];
                    $image_height = $image_size[1];
                    $orientation = 1; // 默认为正常方向
                }
                // 使用关联数组作为元素，包括修改日期和文件名
                $image_details[] = array('path' => $image_path, 
                'modified_time' => $modified_time, 
                'file_name' => $file, 
                'height' => $image_height, 
                'width' => $image_width,
                'orientation' => $orientation);
            }
        }

        // 定义一个自定义排序函数，按照修改日期降序排序
        function customSort($a, $b)
        {
            if ($a['modified_time'] != $b['modified_time']) {
                return $b['modified_time'] - $a['modified_time'];
            } else {
                return strcmp($a['file_name'], $b['file_name']);
            }
        }

        // 使用自定义排序函数对数组进行排序
        usort($image_details, 'customSort');


        // 分割图片数据为三部分，每部分给一个列
        $columns = [[], [], []];
        $heights = [0, 0, 0];
        $varrr=0;
        foreach ($image_details as $image) {
            // 找出当前高度最小的列
            $min_height = min($heights);
            $min_height_index = array_search($min_height, $heights);

            $columns[$min_height_index][] = $image;

            // 调试输出
            //echo "Current heights after adding image:<br>";
            /*$varrr+=1;
            var_dump( $varrr,"---",
            $heights,
            $min_height_index,
            $image['file_name'],
            $image['height'] , 
            $image['width'],
            $image['orientation']);
            echo "<br>";*/
            if (($image['height'] > $image['width']&&$image['orientation']<5) 
                || ($image['height'] < $image['width']&&$image['orientation']>4 )) {
                $heights[$min_height_index] += 9;
            } else {
                $heights[$min_height_index] += 4;
                
            }
        }

        ?>

        <div class="clearfix">
            <?php for ($i = 0; $i < 3; $i++) : ?>
                <div class="column">
                    <?php foreach ($columns[$i] as $image) : ?>
                        <a href="newpage.php?image=<?php echo urlencode($image['path']); ?>" target="_blank">
                            <img src="<?php echo $image['path']; ?>" alt="<?php echo $image['file_name']; ?>">
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endfor; ?>
        </div>
    <div class="prec">
        <h1>ChaoChao & YangYuan</h1>
        <h2>家庭照片共享和展示网站</h2>
        <h9>------------------</h9>
        <div>
            <a href="#community">Community</a>
            <a href="#about">About</a>
            <a href="#license-summary">License Summary</a>
        </div>
    </div>
</body>

</html>
