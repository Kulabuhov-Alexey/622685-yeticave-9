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
            } else if (is_string($value)) {
                $type = 's';
            } else if (is_double($value)) {
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

$is_auth = rand(0, 1); // для имитации авторизации

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
 * @param string время до которого будет длиться распродажа(берется из таблицы stuff->dt_end)
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
 * функция для выборки категорий
 * @author KulabuhovAlexey
 * @param mixed подключение к бызе данных
 * @return array массив категорий
 */
function select_categories($con)
{
    $sql = 'SELECT name, symbol_code 
        FROM categories';
    $result = mysqli_query($con, $sql);
    if ($result == false) {
        print("Произошла ошибка при выполнении запроса 'select_category'");
    } else {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $categories;
}
/**
 * функция для выборки лотов
 * @author KulabuhovAlexey
 * @param mixed подключение к бызе данных
 * @return array массив лотов
 */
function select_items($con)
{
    $sql = 'SELECT stuff.name, categories.name AS category, start_price, photo_url, stuff.id, current_price, dt_end   
            FROM stuff
            JOIN categories ON category = categories.id ;';
    $result = mysqli_query($con, $sql);
    if ($result == false) {
        print("Произошла ошибка при выполнении запроса 'select_items'");
    } else {
        $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $items;
}

/**
 * функция для выборки одного лота
 * @author KulabuhovAlexey
 * @param mixed подключение к бызе данных
 * @return array массив с данными лота
 */
function select_item($con, $id)
{
    $sql = 'SELECT stuff.name, categories.name AS category, start_price, photo_url, stuff.id, description, current_price, step_call, dt_end  
            FROM stuff
            JOIN categories ON category = categories.id
            WHERE stuff.id =' . $id;
    $result = mysqli_query($con, $sql);
    if ($result == false) {
        print("Произошла ошибка при выполнении запроса 'select_item'");
    } else {
        $item = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $item;
}
