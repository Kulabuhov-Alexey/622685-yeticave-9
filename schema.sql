DROP DATABASE IF EXISTS yeticave;

CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    symbol_code VARCHAR(30) 
);
CREATE INDEX i_cat_n ON categories(name);

CREATE TABLE stuff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    name VARCHAR(100) NOT NULL,
    description BLOB,
    photo_url VARCHAR(255),
    start_price INT,
    current_price INT,
    dt_end TIMESTAMP,
    step_call INT,
    user_id INT,
    winner INT,
    category INT     
); 
CREATE INDEX i_st_n ON stuff(name);

CREATE TABLE bet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    price INT,
    user_id INT,
    lot_id INT
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(254) NOT NULL UNIQUE,
    name VARCHAR(30) NOT NULL,
    pass VARCHAR(20), 
    avatar_url VARCHAR(255),
    contact TEXT
);
CREATE INDEX i_us_e ON users(email);
CREATE INDEX i_us_n ON users(name);
