<?php
require_once('helpers.php');
require_once('config.php');

$sql_categories = 'SELECT name, symbol_code 
        FROM categories';

$sql_items = "SELECT stuff.name, categories.name AS category, start_price, photo_url, stuff.id, current_price, dt_end, winner   
            FROM stuff
            JOIN categories ON category = categories.id 
            WHERE MATCH(stuff.name,description) AGAINST(?)
            ORDER BY stuff.dt_add DESC";

$categories = db_fetch_data($con, $sql_categories);
$search_phrase = trim($_GET['search']) ?? '';

if ($search_phrase) {
    $items = db_fetch_data($con, $sql_items, [$search_phrase]);
    $items = bets_stat($items, $_SESSION['user'][0]['id']);
}

$nav = include_template('nav.php', [
    'categories' => $categories
]);

$page_content = include_template('search.php', [
    'nav' => $nav,
    'categories' => $categories,
    'items' => $items,
    'search_phrase' => $search_phrase
]);

$layout_content = include_template('layout.php', [
    'nav' => $nav,
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Результаты поиска',
    'active_user' => $active_user,
    'search_phrase' => $search_phrase
]);

print($layout_content);
