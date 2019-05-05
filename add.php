<?php
require_once('helpers.php');
require_once('config.php');

$sql_categories = 'SELECT name, symbol_code 
                   FROM categories';

$categories = fetch_all($con, $sql_categories);


$page_content = include_template('add.php', [
    'categories' => $categories
]);

//нажимаем добавить лот
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //валидация
    $errors = [];

    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            $errors[$key] = 'Это поле надо заполнить';
        }
        if ($key == 'category' && $value == 'Выберите категорию') {
            $errors[$key] = 'Выберите категорию';
        }
        if ($key == 'lot-rate' && !(is_numeric($value) && $value > 0)) {
            $errors[$key] = 'Цена должна быть больше 0';
        }
        if ($key == 'lot-date' && !(is_date_valid($value) && ((strtotime($value . ' 23:59:59') - time()) / 3600) >= 24)) {
            $errors[$key] = 'Дата должна быть больше текущей минимум на 1 день';
        }
        if ($key == 'lot-step' && !((int)$value == $value && $value > 0)) {
            $errors[$key] = 'Ставка должна быть целым числом и больше 0';
        }
    }
    //валидация фото
    if (!empty($_FILES['pic']['name']) && !count($errors)) {
        $file_type = mime_content_type($_FILES['pic']['tmp_name']);
        if ($file_type !== "image/png" && $file_type !== "image/jpeg") {
            $errors['pic'] = 'Загрузите картинку в формате jpg, jpeg или png';
        } else {
            $file_name = uniqid() . '.jpg';
            $file_path = __DIR__ . '/uploads/';
            $file_url = '/622685-yeticave-9/uploads/' . $file_name;
            move_uploaded_file($_FILES['pic']['tmp_name'], $file_path . $file_name);
        }
    } else {
        $errors['pic'] = 'Выберите файл';
    }

    if (count($errors)) {
        $page_content = include_template('add.php', ['categories' => $categories, 'errors' => $errors, 'post' => $_POST]);
    } else {

        $sql_item = 'SELECT id  
                     FROM stuff
                     WHERE photo_url = \'' . $file_url . '\'';

        $sql_ins_item = 'INSERT INTO stuff
                         (name, description, photo_url, start_price, current_price, dt_end, step_call, user_id, category) VALUE 
                         (?, ?, ?, ?, 11999, ?, ?, 1, ?)';

        $sql_category_id = 'SELECT id 
                            FROM categories
                            WHERE name =\'' . $_POST['category'] . '\'';
        $category_id = fetch_all($con, $sql_category_id);

        if (db_insert_data($con, $sql_ins_item, [$_POST['lot-name'], $_POST['message'], $file_url, $_POST['lot-rate'], $_POST['lot-date'] . ' 23:59:59', $_POST['lot-step'], $category_id[0]['id']])) {
            header("Location: lot.php?id=" . fetch_all($con, $sql_item)[0]['id']);
        }
    }
}

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Добаление лота',
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);
