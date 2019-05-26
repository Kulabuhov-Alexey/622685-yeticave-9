<?php
require_once('helpers.php');
require_once('config.php');

if (!($active_user)) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

$sql_categories = 'SELECT name, symbol_code 
                   FROM categories';

$categories = db_fetch_data($con, $sql_categories);

$nav = include_template('nav.php', [
    'categories' => $categories,
    'cat_class' => $cat_class
]);

$page_content = include_template('add.php', [
    'nav' => $nav,
    'categories' => $categories,
    'cat_class' => $cat_class,
    'errors' => $errors
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validate($_POST);
    if (!empty($_FILES['pic']['name']) && !count($errors)) {
        $file_type = mime_content_type($_FILES['pic']['tmp_name']);
        if ($file_type !== "image/png" && $file_type !== "image/jpeg") {
            $errors['pic'] = 'Загрузите картинку в формате jpg, jpeg или png';
        } else {
            $file_name = uniqid() . ($file_type === "image/png" ? '.png' : '.jpg');
            $file_path = __DIR__ . '/uploads/';
            move_uploaded_file($_FILES['pic']['tmp_name'], $file_path . $file_name);
        }
    } else {
        $errors['pic'] = 'Выберите файл';
    }

    if (count($errors)) {
        $page_content = include_template('add.php', [
            'categories' => $categories,
            'errors' => $errors,
            'post' => $_POST,
            'nav' => $nav
        ]);
    } else {

        $sql_ins_item = 'INSERT INTO stuff
                         (name, description, photo_url, start_price, current_price, dt_end, step_call, user_id, category) VALUE 
                         (?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $sql_category_id = 'SELECT id 
                            FROM categories
                            WHERE name = ?';
        $category_id = db_fetch_data($con, $sql_category_id, [$_POST['category']]);
        $item_id = db_insert_data($con, $sql_ins_item, [$_POST['lot-name'], $_POST['message'], $file_name, $_POST['lot-rate'], $_POST['lot-rate'], $_POST['lot-date'] . ' 23:59:59', $_POST['lot-step'], $_SESSION['user'][0]['id'], $category_id[0]['id']]);
        if ($item_id) {
            header('Location: lot.php?id=' . $item_id);
        }
    }
}

$layout_content = include_template('layout.php', [
    'nav' => $nav,
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Добаление лота',
    'active_user' => $active_user,
    'search_phrase' => $search_phrase
]);

print($layout_content);
