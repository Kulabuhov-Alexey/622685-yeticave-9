<?php
require_once('helpers.php');
require_once('config.php');


$sql_items = "SELECT stuff.id, stuff.photo_url, stuff.name, categories.name AS category, stuff.dt_end,  stuff.current_price, price, bet.dt_add, winner, bet.user_id AS user_id, description
                FROM bet
                JOIN stuff ON bet.lot_id = stuff.id
                JOIN categories
                WHERE bet.user_id = {$_SESSION['user'][0]['id']}
                GROUP BY stuff.id
                ORDER BY bet.dt_add DESC";

$sql_categories = 'SELECT name, symbol_code 
                  FROM categories';

$items = db_fetch_data($con, $sql_items);

$items = bets_stat($items,$_SESSION['user'][0]['id']);

$categories = db_fetch_data($con, $sql_categories);

$nav = include_template('nav.php', [
    'categories' => $categories
]);

$page_content = include_template('my-bets.php', [
    'nav' => $nav,
    'items' => $items,
    'categories' => $categories,
    'active_user' => $active_user
]);

$layout_content = include_template('layout.php', [
    'nav' => $nav,
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Мои ставки',
    'user_name' => $user_name,
    'active_user' => $active_user
]);
print($layout_content);
