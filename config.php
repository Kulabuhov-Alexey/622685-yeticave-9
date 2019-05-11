<?php 
date_default_timezone_set("Europe/Moscow");

$host = 'localhost'; // адрес сервера 
$database = 'yeticave'; // имя базы данных
$user = 'root'; // имя пользователя
$password = ''; // пароль

//Подключение к БД
$con = mysqli_connect($host, $user, $password, $database);
if (!$con) {
    die('Connection FAILED ' . mysqli_connect_error());
} else {
    mysqli_set_charset($con, 'utf-8');
}