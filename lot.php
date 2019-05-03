<?php
require_once('helpers.php');
require_once('config.php');

$id = intval($_GET['id']);
$item = select_item($con, $id);
$categories = select_categories($con);

if ($id && count($item) != 0) {
    $page_content = include_template('lot.php', [
        'item' => $item,
        'categories' => $categories
    ]);
} else {
    $page_content = include_template('404.php', [
    'categories' => $categories
    ]);
}

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => $item[0]['name'] ?? 'Ошибка: такой страницы не существует',
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);
print($layout_content);
