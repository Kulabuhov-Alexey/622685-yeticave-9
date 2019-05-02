<?php
require_once('helpers.php');
require_once('config.php');

$sql = 'SELECT name, symbol_code 
        FROM categories';
$sql2 = 'SELECT stuff.name, categories.name AS category, start_price, photo_url, stuff.id, current_price, dt_end   
        FROM stuff
        JOIN categories ON category = categories.id ;';
$result = mysqli_query($con, $sql);
$result2 = mysqli_query($con, $sql2);
if ($result && $result2 == false) {
    print("Произошла ошибка при выполнении запросов");
} else {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $items = mysqli_fetch_all($result2, MYSQLI_ASSOC);
}

$page_content = include_template('index.php', [
    'categories' => $categories,
    'items' => $items,
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная',
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);
