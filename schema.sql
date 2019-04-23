CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(30) NOT NULL,
    symbol_code CHAR(30) 
);
CREATE INDEX i_cat ON categories(id);
CREATE INDEX i_cat ON categories(name);

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
CREATE INDEX i_st_d ON stuff(description(1000));
CREATE INDEX i_st_i ON stuff(id);

CREATE TABLE bet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total INT,
    author_id CHAR,
    lot_id INT
);
CREATE INDEX i_bet ON bet(id);

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
CREATE INDEX i_email ON users(email);