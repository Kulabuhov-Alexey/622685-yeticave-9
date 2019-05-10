<?php
require_once('helpers.php');
require_once('config.php');

$sql_categories = 'SELECT name, symbol_code 
                   FROM categories';

$categories = db_fetch_data($con, $sql_categories);

$nav = include_template('nav.php', [
    'categories' => $categories
]);

$page_content = include_template('sign-up.php', [
    'nav' => $nav,
    'categories' => $categories
]);

//нажимаем добавить лот
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //валидация
    $errors = validate($_POST);
    //валидация email
    if (empty($errors['email'])) {
        $sql_email = 'SELECT id 
                      FROM users
                      WHERE email = ?';
        $user_id = db_fetch_data($con, $sql_email, [$_POST['email']]);
        if (!empty($user_id)) {
            $errors['email'] = 'Данный адрес уже используется';
        }
    }

    if (count($errors)) {
        $page_content = include_template('sign-up.php', ['categories' => $categories, 'errors' => $errors, 'post' => $_POST]);
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql_ins_user = 'INSERT INTO users
                         (email, pass, name, contact) VALUE 
                         (?, ?, ?, ?)';

        $user_id = db_insert_data($con, $sql_ins_user, [$_POST['email'], $password, $_POST['name'], $_POST['message']]);
        if ($user_id) {
            header('Location: login.php');
        }
    }
}

$layout_content = include_template('layout.php', [
    'nav' => $nav,
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Добаление лота',
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);
