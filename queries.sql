/*Запросы на создание записей*/
/*Вносим первоначальные данные в таблицу Категории(*/ 
INSERT INTO categories
    (name, symbol_code) 
VALUE
    ('Доски и лыжи', 'boards'), ('Крепления', 'attachment'), ('Ботинки', 'boots'),
    ('Одежда', 'clothing'), ('Инструменты', 'tools'), ('Разное', 'other');

/*Вносим первоначальные данные в таблицу Пользователи*/ 
INSERT INTO users
    (email, name, pass, avatar_url, contact) VALUE 
    ('vasya@gmail.com', 'Vasya', PASSWORD('123'), 'img/pic', '+79508014577'),
    ('petya@gmail.com', 'Petya', PASSWORD('456'), 'img/pic', '+79205558844');

/*Вносим первоначальные данные в таблицу Лоты*/
INSERT INTO stuff
    (name, description, photo_url, start_price, dt_end, step_call, user_id, category) VALUE 
    ('2014 Rossignol District Snowboard', '', 'img/lot-1.jpg', 10999, '0', 100, 1, 1),
    ('DC Ply Mens 2016/2017 Snowboard', '', 'img/lot-2.jpg', 159999, '0', 100, 2, 1),
    ('Крепления Union Contact Pro 2015 года размер L/XL', '', 'img/lot-3.jpg', 8000, '0', 100, 1, 2),
    ('Ботинки для сноуборда DC Mutiny Charocal', '', 'img/lot-4.jpg', 10999, '0', 100, 2, 3),
    ('Куртка для сноуборда DC Mutiny Charocal', '', 'img/lot-5.jpg', 7500, '0', 100, 1, 4),
    ('Маска Oakley Canopy', '', 'img/lot-6.jpg', '5400', '0', 100, 2, 6);

/*Вносим первоначальные данные в таблицу Ставки(*/ 
INSERT INTO bet
    (price, lot_id, user_id) VALUE (3000,1,1), (4000,2,2), (5000,1,2);

/*Запросы на выборку данных*/
/*Выбираем все строки из таблицы Категории*/
SELECT name, symbol_code FROM categories;

/*Выбираем самые новые, открытые лоты. Каждый лот должен включать название,
 стартовую цену, ссылку на изображение, цену, название категории*/
SELECT name, start_price, photo_url, current_price, category FROM stuff WHERE winner IS NULL 
AND dt_add >= 0 ORDER BY dt_add ASC ;

/*Показываем лот по его id. Получаем название категории, к которой принадлежит лот*/
SELECT s.name, s.description, photo_url, start_price, dt_end, step_call, c.name FROM stuff s INNER JOIN categories c ON s.category = c.id;

/*Обновляем название лота по его идентификатору*/
UPDATE stuff SET name = '2014 Rossignol District Snowboard' WHERE id = 1;

/*Получаем список самых свежих ставок для лота по его идентификатору*/
SELECT price, lot_id, user_id FROM bet WHERE dt_add BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW();