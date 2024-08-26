import mysql.connector
from mysql.connector import Error
import sys
import bcrypt

# MySQL数据库连接信息
hostname = "localhost"
username = "root"
password = "19941208"
database = "photo"

# 尝试连接数据库
try:
    conn = mysql.connector.connect(
        host=hostname, user=username, password=password, database=database
    )

    if conn.is_connected():
        print("数据库连接成功")

        # 从 PHP 接收参数
        username = sys.argv[1]
        password = sys.argv[2]
        email = sys.argv[3]

        # 检查用户是否已经存在
        cursor = conn.cursor()
        cursor.execute(
            "SELECT * FROM users WHERE username = %s OR email = %s", (username, email)
        )
        results = cursor.fetchall()  # 获取查询结果

        if len(results) > 0:
            print("错误：用户已注册。")
            cursor.close()
            conn.close()
            exit()

        # 插入新用户
        hashed_password = bcrypt.hashpw(password.encode('utf-8'), bcrypt.gensalt())
        insert_query = (
            "INSERT INTO users (username, password, email) VALUES (%s, %s, %s)"
        )
        user_data = (username, hashed_password, email)
        cursor.execute(insert_query, user_data)
        conn.commit()

        print("注册成功！")

        cursor.close()
        conn.close()

except Error as e:
    print(f"连接错误: {e}")

finally:
    if conn.is_connected():
        conn.close()
        print("数据库连接已关闭")
