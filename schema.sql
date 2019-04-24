CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(30) NOT NULL,
    symbol_code CHAR(30) 
);
CREATE INDEX i_cat_i ON categories(id);
CREATE INDEX i_cat_n ON categories(name);

CREATE TABLE stuff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    name CHAR(30),
    description TEXT,
    photo_url TEXT,
    start_price INT,
    dt_end TIMESTAMP,
    step_call INT,
    author_id CHAR,
    winner CHAR,
    category CHAR     
); 
CREATE INDEX i_st_n ON stuff(name);
CREATE INDEX i_st_a ON stuff(author_id);
CREATE INDEX i_st_w ON stuff(winner);
CREATE INDEX i_st_c ON stuff(category);

CREATE TABLE bet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total INT,
    author_id CHAR,
    lot_id INT
);
CREATE INDEX i_bet_a ON bet(author_id);
CREATE INDEX i_bet_l ON bet(lot_id);

CREATE TABLE users (
    dt_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email CHAR PRIMARY KEY NOT NULL UNIQUE,
    name CHAR,
    pass CHAR, 
    avatar_url TEXT,
    contact TEXT,
    lot_id INT,
    bet_id INT
);
CREATE INDEX i_us_e ON users(email);
CREATE INDEX i_us_l ON users(lot_id);
CREATE INDEX i_us_b ON users(bet_id);
CREATE INDEX i_us_n ON users(name);
