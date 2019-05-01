<?php
require_once('helpers.php');
require_once('config.php');

//Подключение к БД
$con = @mysqli_connect($host, $user, $password, $database);
if (!$con) {
    die ('Connection FAILED ' . mysqli_connect_error());
}
else {
mysqli_set_charset($con, 'utf-8');
}
$sql = 'SELECT name, symbol_code 
        FROM categories';
$sql2 = 'SELECT stuff.name, categories.name AS category, start_price, photo_url 
        FROM stuff
        JOIN categories ON category = categories.id ;';
$result = mysqli_query($con, $sql);
$result2 = mysqli_query($con, $sql2);
if ($result&&$result2 == false) {
    print("Произошла ошибка при выполнении запросов");
}
else {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $items = mysqli_fetch_all($result2, MYSQLI_ASSOC);
}

$user_name = 'Alexey'; // укажите здесь ваше имя

$is_auth = rand(0, 1);

$timer_finishing = date('H') < 23 ?:'timer--finishing' ;// для добавления модификатора в случае если до конца распродажи(суток) остается меньше часа


/**
 * функция для форматирования отображения цены
 * @param integer $price - неотформатированная цена
 * @author KulabuhovAlexey
 * @return string - возвращаем отформатированную цену
 */        
function format_price ($price) {
    //форматируем полученное число через встроенную ф-цию и добавляем пробел со знаком рубля
    return number_format($price , 0 , ' , ' , ' ').' &#8381;';    
}
/**
 * функция для отображения времени оставшегося до конца распродажи
 * время выводится в заданном формате 'ЧЧ:ММ'
 * @author KulabuhovAlexey
 * @return возвращаем время до конца распродажи(полночь)
 */
function time_sell_off ($finish_sell_time) {
    $t1 = date_create('now');
    $t2 = date_create($finish_sell_time);
    return date_diff($t2, $t1)->format('%H:%i'); 
}

$page_content = include_template('index.php', [
    'categories' => $categories, 
    'items' => $items,
    'timer_finishing' => $timer_finishing,
    'finish_sell_time' => $finish_sell_time
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная',
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);
?>