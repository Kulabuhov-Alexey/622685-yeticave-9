<?php
require_once('helpers.php');
require_once('config.php');

$id = intval($_GET['id']);

//Формирование запроса на поиск лота по переданному через GET id
$sql = 'SELECT stuff.name, categories.name AS category, start_price, photo_url, stuff.id, description, current_price, step_call, dt_end  
        FROM stuff
        JOIN categories ON category = categories.id
        WHERE stuff.id =' . $id;
$result = mysqli_query($con, $sql);
if ($result == false) {
    print("Произошла ошибка при выполнении запросов");
} else {
    $item = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

if ($id && count($item) != 0) {
    print(count($item));
    $page_content = include_template('lot.php', [
        'item' => $item,
    ]);
} else {
    $page_content = include_template('404.php');
}
print($page_content);
