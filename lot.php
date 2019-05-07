<?php
require_once('helpers.php');
require_once('config.php');

$id = intval($_GET['id']);

$sql_item = 'SELECT stuff.name, categories.name AS category, start_price, photo_url, stuff.id, description, current_price, step_call, dt_end  
            FROM stuff
            JOIN categories ON category = categories.id
            WHERE stuff.id =' . $id;

$sql_categories = 'SELECT name, symbol_code 
                  FROM categories';

$item = fetch_all($con, $sql_item);
$categories = fetch_all($con, $sql_categories);

$nav = include_template('nav.php', [
    'categories' => $categories
]);

if ($id && count($item) != 0) {
    $page_content = include_template('lot.php', [
        'nav' => $nav,
        'item' => $item,
        'categories' => $categories
    ]);
} else {
    $page_content = include_template('404.php', [
        'nav' => $nav,
        'categories' => $categories
    ]);
}

$layout_content = include_template('layout.php', [
    'nav' => $nav,
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => $item[0]['name'] ?? 'Ошибка: такой страницы не существует',
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);
print($layout_content);
