import os
import subprocess

def find_files(directory):
    """搜索目录中的所有文件，并返回文件路径列表"""
    file_paths = []
    for root, _, files in os.walk(directory):
        for file in files:
            file_paths.append(os.path.join(root, file))
    return file_paths

def main():
    directory = '4K'  # 需要搜索的目录
    file_paths = find_files(directory)
    
    for file_path in file_paths:
        #print(file_path)
        subprocess.run(['python3', 'imageZ.py', file_path])

if __name__ == "__main__":
    main()
