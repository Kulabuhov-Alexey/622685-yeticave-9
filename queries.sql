/*Запросы на создание записей*/
/*Вносим первоначальные данные в таблицу Категории(*/ 
INSERT INTO categories
    (name, symbol_code) 
VALUE
    ('Доски и лыжи', 'boards'), ('Крепления', 'attachment'), ('Ботинки', 'boots'),
    ('Одежда', 'clothing'), ('Инструменты', 'tools'), ('Разное', 'other');

/*Вносим первоначальные данные в таблицу Пользователи*/
/*Пароли для тестовых пользователей '123'*/ 
INSERT INTO users
    (email, name, pass, avatar_url, contact) VALUE 
    ('kulabuha@gmail.com', 'Vasya', '$2y$10$DV3jwKzHSNUHNbod.56SkueFmUV6fmXXM6EKICXZ61QHfWj3emUGO', 'img/pic', '+79508014577'), 
    ('kulabuhov_ae@nlmk.com', 'Petya', '$2y$10$DV3jwKzHSNUHNbod.56SkueFmUV6fmXXM6EKICXZ61QHfWj3emUGO', 'img/pic', '+79205558844');

/*Вносим первоначальные данные в таблицу Лоты*/
INSERT INTO stuff
    (name, description, photo_url, start_price, current_price, dt_end, step_call, user_id, category, winner) VALUE 
    ('2014 Rossignol District Snowboard', 'Классная доска +79508888', 'lot-1.jpg', 10999, 11999, NOW(), 100, 1, 1, NULL),
    ('DC Ply Mens 2016/2017 Snowboard', 'Классная доска +79508888', 'lot-2.jpg', 159999, 169999, NOW(), 100, 2, 1, NULL),
    ('Крепления Union Contact Pro 2015 года размер L/XL', '', 'lot-3.jpg', 8000, 9000, DATE_ADD(NOW(), INTERVAL 1 HOUR), 100, 1, 2, NULL),
    ('Ботинки для сноуборда DC Mutiny Charocal', '', 'lot-4.jpg', 10999, 10999,DATE_ADD(NOW(), INTERVAL 2 DAY), 100, 2, 3, NULL),
    ('Куртка для сноуборда DC Mutiny Charocal', '', 'lot-5.jpg', 7500, 7500,DATE_ADD(NOW(), INTERVAL 2 DAY), 100, 1, 4, NULL),
    ('Маска Oakley Canopy', '', 'lot-6.jpg', 5400, 5400, DATE_ADD(NOW(), INTERVAL 2 DAY), 100, 2, 6, NULL);

/*Вносим первоначальные данные в таблицу Ставки(*/ 
INSERT INTO bet
    (price, lot_id, user_id) VALUE (11400,1,2),(11500,1,2), (169999,2,2), (11999,1,1), (9000,3,1);

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