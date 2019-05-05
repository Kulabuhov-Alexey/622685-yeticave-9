<?php
require_once('helpers.php');
require_once('config.php');

$sql_categories = 'SELECT name, symbol_code 
        FROM categories';

$sql_items = 'SELECT stuff.name, categories.name AS category, start_price, photo_url, stuff.id, current_price, dt_end   
            FROM stuff
            JOIN categories ON category = categories.id ;';

$categories = fetch_all($con, $sql_categories);

$page_content = include_template('index.php', [
    'categories' => $categories,
    'items' => fetch_all($con, $sql_items)
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная',
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);
