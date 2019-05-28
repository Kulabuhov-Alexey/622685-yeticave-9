<?php
require_once('helpers.php');
require_once('config.php');

$sql_categories = 'SELECT name, symbol_code
                   FROM categories';

$categories = db_fetch_data($con, $sql_categories);

$nav = include_template('nav.php', [
    'categories' => $categories,
    'cat_class' => $cat_class
]);

$page_content = include_template('login.php', [
    'nav' => $nav,
    'categories' => $categories,
    'active_user' => $active_user,
    'errors' => $errors
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (0 === count(array_diff(['email', 'password'], array_keys($_POST))))) {
    $errors = validate($_POST);
    if (empty($errors)) {
        $sql_email = 'SELECT id, pass, email, name
                      FROM users
                      WHERE email = ?';
        $user = db_fetch_data($con, $sql_email, [$_POST['email']]);
        if (!empty($user)) {
            if (password_verify($_POST['password'], $user[0]['pass'])) {
                $_SESSION['user'] = $user;
            } else {
                $errors['password'] = 'Неверный пароль';
            }
        } else {
            $errors['email'] = 'Данный пользователь не найден.';
        }
    }

    if (!empty($errors)) {
        $page_content = include_template('login.php', [
            'nav' => $nav,
            'categories' => $categories,
            'errors' => $errors,
            'post' => $_POST
        ]);
    } else {
        header('Location: index.php');
    }
}

$layout_content = include_template('layout.php', [
    'nav' => $nav,
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Авторизация пользователя',
    'active_user' => $active_user,
    'search_phrase' => $search_phrase
]);

print($layout_content);
