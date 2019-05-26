<?php
require_once('helpers.php');
require_once('config.php');

$sql_categories = 'SELECT name, symbol_code 
        FROM categories';

$sql_items = 'SELECT stuff.name   
            FROM stuff
            WHERE MATCH(stuff.name,description) AGAINST(?) AND dt_end > NOW()';

$search_phrase = trim($_GET['search']) ?? '';
$items = db_fetch_data($con, $sql_items, [$search_phrase]);
$categories = db_fetch_data($con, $sql_categories);

$cur_page = $_GET['page'] ?? 1;
$page_items = 9;
$items_count = count($items);
$pages_count = ceil($items_count / $page_items);
$offset = ($cur_page - 1) * $page_items;
$pages = range(1, $pages_count);
$sql_items = 'SELECT stuff.name, categories.name AS category, start_price, photo_url, stuff.id, current_price, dt_end, winner   
            FROM stuff
            JOIN categories ON category = categories.id 
            WHERE MATCH(stuff.name,description) AGAINST(?) AND dt_end > NOW()
            ORDER BY stuff.dt_add DESC
            LIMIT ? OFFSET ?';
$items = db_fetch_data($con, $sql_items, [$search_phrase, $page_items, $offset]);
if ($search_phrase) {
    $items = db_fetch_data($con, $sql_items, [$search_phrase, $page_items, $offset]);
    $items = bets_stat($items, $active_user[0]['id']);
}

$pagination = include_template('pagination.php', [
    'pages_count' => $pages_count,
    'cur_page' => $cur_page,
    'search_phrase' => $search_phrase,
    'pages' => $pages
]);

$nav = include_template('nav.php', [
    'categories' => $categories
]);

$page_content = include_template('search.php', [
    'nav' => $nav,
    'categories' => $categories,
    'items' => $items,
    'search_phrase' => $search_phrase,
    'pagination' => $pagination
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
