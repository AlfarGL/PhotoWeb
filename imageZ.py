from PIL import Image, ExifTags
'''
import sys
sys.path.append('/home/lighthouse/.local/lib/python3.10/site-packages/pillow_avif')
'''
import pillow_avif
import argparse
from pathlib import Path
import subprocess

def get_image_orientation(img):
    """
    获取图片的方向信息。
    :param img: PIL.Image对象
    :return: 图片的方向标记（Orientation），如果没有方向信息则返回 None
    """
    try:
        for orientation in ExifTags.TAGS.keys():
            if ExifTags.TAGS[orientation] == 'Orientation':
                break

        exif = img._getexif()
        if exif is not None:
            return exif.get(orientation, None)
    except Exception as e:
        print("Error:", e)
    return None

def is_horizontal_image(img):
    """
    判断图片是否为横版图片。
    :param img: PIL.Image对象
    :return: True（横版图片）或 False（竖版图片）
    """
    #orientation = get_image_orientation(img)
    #if orientation in [3, 4, 5, 6, 7, 8]:
    width = img.width 
    height = img.height
    if width>height:
        print("heng")
        return True
    else:
        print("shu")
        return False

def is_vertical_image(img):
    """
    判断图片是否为竖版图片。
    :param img: PIL.Image对象
    :return: True（竖版图片）或 False（横版图片）
    """
    return not is_horizontal_image(img)

def adjust_image_ratio(img):
    """
    调整图片的宽高比例为3:2
    :param img: 图片对象
    :return: 调整后的图片对象
    """
    # 获取图片的尺寸
    width = img.width 
    height = img.height
    print(width,"  ",height)
    # 如果图片宽高比例不是3:2，则进行调整
    if width / height != 3 / 2:
        if is_horizontal_image(img):
            # 计算调整后的尺寸
            new_width = width
            new_height = int(width * 2 / 3)
            
            #if new_height+10<height:
            if new_height>height:
                new_width = int(height * 3 / 2)
                new_height = height
            
            print(new_width,"  ",new_height)     
             # 创建黑色背景的图片
            black_border = Image.new('RGB', (new_width, new_height), (0, 0, 0))
             # 计算将原图粘贴到黑色背景上的位置
            paste_x = (new_width - width) // 2
            paste_y = (new_height - height) // 2
        
            # 将原图粘贴到黑色背景上
            black_border.paste(img, (paste_x, paste_y))
        else:
            # 计算调整后的尺寸
            new_width = width
            new_height = int(width * 3/ 2)
            
            #if new_height+10<height:
            if new_height>height:
                #new_width = int(height * 3 / 2)
                new_width = int(height * 2/ 3)
                new_height = height
            
            print(new_width,"  ",new_height) 
             # 创建黑色背景的图片
            black_border = Image.new('RGB', (new_width, new_height), (0, 0, 0))
             # 计算将原图粘贴到黑色背景上的位置
            paste_x = (new_width - width) // 2
            paste_y = (new_height - height) // 2
        
            # 将原图粘贴到黑色背景上
            black_border.paste(img, (paste_x, paste_y))
        
        # 返回调整后的图片对象
        return black_border
    
    # 如果图片已经是3:2的比例，则直接返回原图片对象
    return img

def compress_jpg(input_path, output_path, quality=20):
    """
    压缩 JPG 图片
    :param input_path: 输入图片路径
    :param output_path: 输出图片路径
    :param quality: 压缩质量,范围从1(最差)到95(最好),推荐值是85
    """
    with Image.open(input_path) as img:
        # 获取图像的原始 EXIF 数据
        exif_data = img.info.get("exif")
        # 调整图片比例
        img = adjust_image_ratio(img)
        # 保存图像时传入原始 EXIF 数据
        if exif_data:
            img.save(output_path, "JPEG", quality=quality, exif=exif_data)
        else:
            img.save(output_path, "JPEG", quality=quality)

def compress_avif(input_path, output_path, quality=20):
    """
    压缩 AVIF 图片
    :param input_path: 输入图片路径
    :param output_path: 输出图片路径
    :param quality: 压缩质量,范围从0(最差)到100(最好),推荐值是50
    """
    with Image.open(input_path) as img:
        # 获取图像的原始 EXIF 数据
        exif_data = img.info.get("exif")
         # 调整图片比例
        img = adjust_image_ratio(img)
        # 保存图像时传入原始 EXIF 数据
        if exif_data:
            img.save(output_path, "AVIF", quality=quality, exif=exif_data)
        else:
            img.save(output_path, "AVIF", quality=quality)

def compress_png(input_path, output_path):
    # 使用pngquant工具进行压缩
    subprocess.run(["pngquant", "--force", "--output", output_path, input_path])

def process_parameters(file_path):
    # 提取文件扩展名和文件名
    ext = Path(file_path).suffix
    name = Path(file_path).stem
    output_file_path =  "/var/www/html/zip/" + ("z"+name+ext)
    print(output_file_path)
    # 将扩展名转换为小写以处理大小写问题
    ext = ext.lower()
    
    # 根据扩展名判断文件类型
    if ext == '.avif':
        compress_avif(file_path, output_file_path)
        return 'AVIF'
    elif ext == '.jpg' or ext == '.jpeg':
        compress_jpg(file_path, output_file_path)
        return 'JPG'
    elif ext == '.png':
        compress_png(file_path, output_file_path)
        return 'PNG'
    else:
        return 'Unknown'


def main():
    parser = argparse.ArgumentParser(description='压缩图片,支持avif和jpg\jpeg')
    parser.add_argument('file_path', type=str, help='图片路径')
    
    # 解析命令行参数
    args = parser.parse_args()
    
    # 调用函数并传递参数
    print(process_parameters(args.file_path))

if __name__ == '__main__':
    main()
