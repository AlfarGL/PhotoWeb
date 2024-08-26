-- 注释了以下三行，用root创建photo，方便修改。密码记得改，如果用。
-- CREATE USER 'yang'@'localhost' IDENTIFIED BY '密码';
-- GRANT ALL PRIVILEGES ON photo.* TO 'yang'@'localhost';  -- 给yang所有权限
-- FLUSH PRIVILEGES;  -- 刷新权限

-- 创建数据库
CREATE DATABASE IF NOT EXISTS photo;

-- 使用该数据库
USE photo;

-- 创建用户表
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL UNIQUE,  -- 假设使用哈希后的密码
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP  -- 如果缺省，填当前时间
);

-- 存储拍摄地点的信息
CREATE TABLE IF NOT EXISTS locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location_name VARCHAR(255) NOT NULL,
    latitude DECIMAL(9, 6), -- 经纬
    longitude DECIMAL(9, 6) 
);

FLUSH PRIVILEGES;

-- 存储照片的基本信息
CREATE TABLE IF NOT EXISTS photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,  -- 文件名
    filepath VARCHAR(255) NOT NULL,  -- 路径
    upload_date DATETIME DEFAULT CURRENT_TIMESTAMP,  -- 上传时间
    description TEXT NOT NULL, -- 简介
    location_id INT NOT NULL,  -- 位置
    shooting_date DATETIME NOT NULL,  -- 拍摄时间 
    user_id INT NOT NULL,  -- 上传用户
    is_private BOOLEAN NOT NULL DEFAULT 0,  -- 隐私属性
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (location_id) REFERENCES locations(id)
);

-- 标签表 (tags) 存储照片标签信息 可以给照片打上“风景”“建筑”等标签
CREATE TABLE IF NOT EXISTS tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tag_name VARCHAR(50) NOT NULL UNIQUE
);

-- 照片标签关系表 (photo_tags) 存储照片与标签的多对多关系
CREATE TABLE IF NOT EXISTS photo_tags (
    photo_id INT,
    tag_id INT,
    PRIMARY KEY (photo_id, tag_id),
    FOREIGN KEY (photo_id) REFERENCES photos(id),
    FOREIGN KEY (tag_id) REFERENCES tags(id)
);
