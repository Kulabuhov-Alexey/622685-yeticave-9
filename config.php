<?php
date_default_timezone_set("Europe/Moscow");

$host = 'localhost'; // адрес сервера 
$database = 'yeticave'; // имя базы данных
$user = 'root'; // имя пользователя
$password = ''; // пароль
$con = mysqli_connect($host, $user, $password, $database); //Подключение к БД

$search_phrase = '';
$errors = '';
$pagination = '';

if (!$con) {
    die('Connection FAILED ' . mysqli_connect_error());
} else {
    mysqli_set_charset($con, 'utf-8');
}

session_start();
!empty($_SESSION['user'][0]['name']) ? $active_user = $_SESSION['user'] : $active_user = NULL;
