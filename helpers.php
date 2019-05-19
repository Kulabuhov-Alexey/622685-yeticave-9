<?php
/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date): bool
{
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            } elseif (is_string($value)) {
                $type = 's';
            } elseif (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form(int $number, string $one, string $two, string $many): string
{
    $number = (int)$number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = [])
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

$user_name = 'Alexey'; // имя пользователя

/**
 * функция для форматирования отображения цены
 * @param integer $price - неотформатированная цена
 * @author KulabuhovAlexey
 * @return string - возвращаем отформатированную цену
 */
function format_price($price)
{
    //форматируем полученное число через встроенную ф-цию и добавляем пробел со знаком рубля
    return number_format($price, 0, ' , ', ' ') . ' &#8381;';
}

/**
 * функция для отображения времени оставшегося до конца распродажи
 * время выводится в заданном формате 'ЧЧ:ММ'
 * @author KulabuhovAlexey
 * @param string $finish_sell_time время до которого будет длиться распродажа(берется из таблицы stuff->dt_end)
 * @return возвращаем время до конца распродажи(в формате ЧЧ:ММ)
 */
function time_sell_off($finish_sell_time)
{
    $dt_diff = strtotime($finish_sell_time) - time();
    $hours = floor($dt_diff / 3600);
    $minutes = floor(($dt_diff % 3600) / 60);
    return str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT);
}

/**
 * функция для выборки значений из базы данных
 * @author KulabuhovAlexey
 * @param object $con подключение к базе данных
 * @param string $sql запрос который нужно выполнить
 * @param array $data  массив с данными для подстановки в подготовленное выражение
 * @return array массив со значениями полученными по запросу
 */
function db_fetch_data($con, $sql, $data = [])
{
    $result = [];
    $stmt = db_get_prepare_stmt($con, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $result;
}

/**
 * функция для ввода данных в базу
 * @author KulabuhovAlexey
 * @param object $con подключение к базе данных
 * @param string $sql запрос который нужно выполнить
 * @param array $data массив с данными для подстановки в подготовленное выражение
 * @return array массив со значениями полученными по запросу
 */
function db_insert_data($con, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($con, $sql, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($con);
    }
    return $result;
}

/**
 * функция валидации данных формы
 * @author KulabuhovAlexey
 * @param array $data массив с полями имя - значение, которые будем валидировать
 * @return array массив с ошибками(если таковые имеются)
 */
function validate($data)
{
    $err = [];
    $validate_case = [   /// сюда записываем функции-валидаторы
        function ($key, $value) {
            if (empty($value) && $value == null) {
                return 'Поле нужно заполнить!!!';
            }
        },
        function ($key, $value) {
            if ($key === 'category' && $value === 'Выберите категорию') {
                return 'Выберите категорию';
            }
        },
        function ($key, $value) {
            if ($key === 'lot-rate' && is_numeric($value) && $value <= 0) {
                return 'Цена должна быть больше 0';
            }
        },
        function ($key, $value) {
            if ($key === 'lot-date' && (is_date_valid($value) && ((strtotime($value . ' 23:59:59') - time()) / 3600) <= 24)) {
                return 'Дата должна быть больше текущей минимум на 1 день';
            }
        },
        function ($key, $value) {
            if (($key === 'lot-step' || $key === 'cost') && ($value != null) && !(filter_var($value, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1))))) {
                return 'Ставка должна быть целым числом и больше 0';
            }
        },
        function ($key, $value) {
            if ($key === 'email' && !empty($value) &&  empty(filter_var($value, FILTER_VALIDATE_EMAIL))) {
                return 'Введен неправильный адрес';
            }
        }
    ];
    foreach ($data  as $key => $value) { ///пробегаем по всем элементам массива, всеми функциями-валидаторами
        foreach ($validate_case as $function) {
            if ($function($key, $value)) {
                $err[$key] = $function($key, $value);
            }
        }
    }
    return $err;
}

/**
 * функция определения статуса торгов
 * @author KulabuhovAlexey
 * @param array $array_of_item массив который включает в себя значение 'dt_end' - дату конца торгов
 * @param int $user_id  - id залогиненного пользователя
 * @return array тот же массив что и был на входе, только добавилась новый подмассив с ключом status и значениями характеризующих статус торгов
 */
function bets_stat($array_of_item, $user_id = [])
{
    foreach ($array_of_item as $key => $value) {
        $time_to_end = strtotime($value['dt_end']) - time();

        if ($time_to_end < 3600 && $time_to_end > 0) {
            $array_of_item[$key]['status'] = ['timer--finishing', time_sell_off($value['dt_end'])];
        }
        if ($time_to_end <= 0) {
            $array_of_item[$key]['status'] = ['timer--end', 'Торги окончены', 'rates__item--end'];
        }

        if ($time_to_end <= 0 && $user_id === $value['winner']) {
            $array_of_item[$key]['status'] = ['timer--win', 'Ставка выйграла', 'rates__item--win'];
        }

        if ($time_to_end > 3600) {
            $array_of_item[$key]['status'] = ['', time_sell_off($value['dt_end'])];
        }
    }
    return $array_of_item;
}

/**
 * функция вывода времени которое прошло с момента ставки
 * @author KulabuhovAlexey
 * @param array $sql_bet_history массив- перечень ставок, который включает в себя значение 'dt_add' - дату добавления ставки
 * @return array тот же массив что и был на входе, только добавился новый элемент с правильным выводом времени прошедшего с момента ставки
 */
function bets_time_format($sql_bet_history)
{
    foreach ($sql_bet_history as $key => $value) {
        $time_add_bet = time() - strtotime($sql_bet_history[$key]['dt_add']);

        if ($time_add_bet >= 0) {
            $sql_bet_history[$key]['time_ago'] = 'Только что';
        }
        if ($time_add_bet > 60) {
            $count_min = intdiv($time_add_bet, 60);
            $sql_bet_history[$key]['time_ago'] = $count_min . ' ' . get_noun_plural_form($count_min, 'минута', 'минуты', 'минут') . ' назад';
        }
        if ($time_add_bet > 3600) {
            $count_hours = intdiv($time_add_bet, 3600);
            $sql_bet_history[$key]['time_ago'] = $count_hours . ' ' . get_noun_plural_form($count_hours, 'час', 'часа', 'часов') . ' назад';
        }
        if ($time_add_bet > 86400) {
            $count_days = intdiv($time_add_bet, 86400);
            $sql_bet_history[$key]['time_ago'] = $count_days . ' ' . get_noun_plural_form($count_days, 'день', 'дня', 'дней') . ' назад';
        }
    }
    return $sql_bet_history;
}
