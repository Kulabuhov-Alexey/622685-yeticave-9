CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE categories (
    name CHAR(30) PRIMARY KEY NOT NULL UNIQUE,
    symbol_code CHAR(30) 
);
CREATE UNIQUE INDEX i_cat ON categories(name);

INSERT INTO categories
(name,symbol_code) VALUE ('Доски и лыжи', 'boards'),('Крепления', 'attachment'),('Ботинки', 'boots'),
('Одежда', 'clothing'),('Инструменты', 'tools'),('Разное', 'other');

CREATE TABLE stuff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    name CHAR(30),
    description VARCHAR(1000),
    photo_url TEXT,
    start_price INT,
    dt_end TIMESTAMP,
    step_call INT,
    author_id CHAR,
    winner CHAR,
    category CHAR,
    FOREIGN KEY (category) REFERENCES categories(name),
    FOREIGN KEY (author_id) REFERENCES users(email),
    FOREIGN KEY (winner) REFERENCES users(email)      
); 

CREATE INDEX i_st_n ON stuff(name);
CREATE INDEX i_st_d ON stuff(description(1000));
CREATE INDEX i_st_i ON stuff(id);

CREATE TABLE bet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ums INT,
    author_id CHAR,
    lot_id INT,
    FOREIGN KEY (author_id) REFERENCES users(email),
    FOREIGN KEY (lot_id) REFERENCES stuff(id) 
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
    bet_id INT,
    FOREIGN KEY (lot_id) REFERENCES stuff(id),
    FOREIGN KEY (bet_id) REFERENCES bet(id)
);
CREATE INDEX i_email ON users(email);