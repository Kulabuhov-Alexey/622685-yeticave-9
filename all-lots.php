<?php
require_once('helpers.php');
require_once('config.php');

$sql_categories = 'SELECT name, symbol_code 
        FROM categories';

$sql_items = 'SELECT stuff.name, categories.name AS category, start_price, photo_url, stuff.id, current_price, dt_end, winner   
            FROM stuff
            JOIN categories ON category = categories.id 
            WHERE categories.name = ?
            ORDER BY stuff.dt_add DESC';

$categories = db_fetch_data($con, $sql_categories);
$category = $_GET['category'] ?? '';

if ($category) {
    $items = db_fetch_data($con, $sql_items, [$category]);
    $items = bets_stat($items, $_SESSION['user'][0]['id']);
}

$nav = include_template('nav.php', [
    'categories' => $categories,
    'cat_class' => $category    
]);

$page_content = include_template('all-lots.php', [
    'nav' => $nav,
    'promo' => $promo,
    'categories' => $categories,
    'items' => $items,
    'search_phrase' => $search_phrase
]);

$layout_content = include_template('layout.php', [
    'nav' => $nav,
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => $category,
    'user_name' => $user_name,
    'active_user' => $active_user,
    'search_phrase' => $search_phrase
]);

print($layout_content);
