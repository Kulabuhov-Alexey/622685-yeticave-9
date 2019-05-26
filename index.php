<?php
require_once('helpers.php');
require_once('config.php');
require_once('getwinner.php');

$sql_categories = 'SELECT name, symbol_code 
        FROM categories';

$sql_items = 'SELECT stuff.name, categories.name AS category, start_price, photo_url, stuff.id, current_price, dt_end, winner   
            FROM stuff
            JOIN categories ON category = categories.id
            WHERE  dt_end > NOW()
            ORDER BY stuff.dt_add DESC';

$categories = db_fetch_data($con, $sql_categories);
$items = db_fetch_data($con, $sql_items);
$items = bets_stat($items, $active_user[0]['id']);

$nav = include_template('nav.php', [
    'categories' => $categories,
    'cat_class' => $cat_class
]);

$promo = include_template('promo.php', [
    'categories' => $categories
]);

$page_content = include_template('index.php', [
    'promo' => $promo,
    'categories' => $categories,
    'items' => $items
]);

$layout_content = include_template('layout.php', [
    'nav' => $nav,
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная',
    'active_user' => $active_user,
    'search_phrase' => $search_phrase
]);

print($layout_content);
