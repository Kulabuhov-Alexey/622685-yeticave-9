<?php
require_once('helpers.php');
require_once('config.php');

$user_name = 'Alexey'; // укажите здесь ваше имя
$is_auth = rand(0, 1);
$timer_finishing = date('H') < 23 ?:'timer--finishing' ;// для добавления модификатора в случае если до конца распродажи(суток) остается меньше часа
$categories = [
    'boards' => 'Доски и лыжи',
    'attachment' => 'Крепления',
    'boots' => 'Ботинки',
    'clothing' => 'Одежда',
    'tools' => 'Инструменты',
    'other' => 'Разное'
];
$items = [
[
    'name' => '2014 Rossignol District Snowboard',
    'category' => $categories['boards'],
    'item_price' => 10999,
    'item_photo' => 'img/lot-1.jpg'
], [
    'name' => 'DC Ply Mens 2016/2017 Snowboard',
    'category' => $categories['boards'],
    'item_price' => 159999,
    'item_photo' => 'img/lot-2.jpg'
], [
    'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
    'category' => $categories['attachment'],
    'item_price' => 8000,
    'item_photo' => 'img/lot-3.jpg'
], [
   'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
   'category' => $categories['boots'],
   'item_price' => 10999,
   'item_photo' => 'img/lot-4.jpg'
], [
   'name' => 'Куртка для сноуборда DC Mutiny Charocal',
   'category' => $categories['clothing'],
   'item_price' => 7500,
   'item_photo' => 'img/lot-5.jpg'
], [
   'name' => 'Маска Oakley Canopy',
   'category' => $categories['other'],
   'item_price' => 5400,
   'item_photo' => 'img/lot-6.jpg'
] 
        ];
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
function time_to_midnight () {
    $t1 = date_create('now');
    $t2 = date_create('tomorrow midnight');
    return date_diff($t2, $t1)->format('%H:%i'); 
}

$page_content = include_template('index.php', [
    'categories' => $categories, 
    'items' => $items,
    'timer_finishing' => $timer_finishing
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