<?php
require_once('helpers.php');
require_once('config.php');

$categories = select_categories($con);

$page_content = include_template('index.php', [
    'categories' => $categories,
    'items' => select_items($con)
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная',
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);
