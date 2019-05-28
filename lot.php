<?php
require_once('helpers.php');
require_once('config.php');

$id = array_key_exists('id', $_GET) ? intval($_GET['id']) : intval('');

$sql_item = 'SELECT stuff.name, categories.name AS category, start_price, photo_url, stuff.id, description, current_price, step_call, dt_end, winner  
             FROM stuff
             JOIN categories ON category = categories.id
             WHERE stuff.id =' . $id;

$sql_categories = 'SELECT name, symbol_code 
                   FROM categories';

$sql_bet_history = 'SELECT dt_add, price, user_id, lot_id, users.name
                    FROM bet
                    JOIN users
                    ON user_id = users.id
                    WHERE lot_id =' . $id . '
                    ORDER BY bet.dt_add DESC';

$sql_ins_cost = 'INSERT INTO bet
                 (price, user_id, lot_id) VALUE 
                 (?, ?, ?)';

$sql_update_stuff = 'UPDATE stuff
                     SET current_price = ? WHERE id  = ?';

$item = db_fetch_data($con, $sql_item);
$item = bets_stat($item, $active_user[0]['id']);

$categories = db_fetch_data($con, $sql_categories);

$bet_history = db_fetch_data($con, $sql_bet_history);
$bet_history = bets_time_format($bet_history);

$nav = include_template('nav.php', [
    'categories' => $categories,
    'cat_class' => $cat_class
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && array_key_exists('cost', $_POST)) {
    $errors = validate($_POST);
    if (empty($errors) && ($item[0]['current_price'] + $item[0]['step_call']) > $_POST['cost']) {
        $errors['cost'] = 'Ставка не может быть меньше минимальной';
    }

    if (empty($errors)) {
        mysqli_query($con, "START TRANSACTION");
        $item_id = db_insert_data($con, $sql_ins_cost, [$_POST['cost'], $_SESSION['user'][0]['id'], $id]);
        $update_stuff = db_insert_data($con, $sql_update_stuff, [$_POST['cost'], $id]);
        if ($item_id && !($update_stuff)) {
            mysqli_query($con, "COMMIT");
            $item = db_fetch_data($con, $sql_item);
            $item = bets_stat($item, $_SESSION['user'][0]['id']);
            $bet_history = db_fetch_data($con, $sql_bet_history);
            $bet_history = bets_time_format($bet_history);
        } else {
            mysqli_query($con, "ROLLBACK");
        }
    }
}

if ($id && count($item) !== 0) {
    $page_content = include_template('lot.php', [
        'nav' => $nav,
        'item' => $item,
        'categories' => $categories,
        'active_user' => $active_user,
        'errors' => $errors,
        'post' => $_POST,
        'bet_history' => $bet_history
    ]);
} else {
    $page_content = include_template('404.php', [
        'nav' => $nav,
        'categories' => $categories
    ]);
}

$layout_content = include_template('layout.php', [
    'nav' => $nav,
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => $item[0]['name'] ?? 'Ошибка: такой страницы не существует',
    'active_user' => $active_user,
    'search_phrase' => $search_phrase
]);
print($layout_content);
