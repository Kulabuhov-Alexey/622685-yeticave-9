<?php
require_once('vendor/autoload.php');

$sql_get_winners = 'SELECT stuff.current_price, stuff.id, bet.user_id, users.email, users.name, stuff.name AS stuff_name
                    FROM stuff
                    JOIN bet ON stuff.id = bet.lot_id AND stuff.current_price = bet.price
                    JOIN users ON bet.user_id = users.id
                    WHERE  winner IS NULL AND dt_end <= NOW()';

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");
$recipients = [];


$winners = db_fetch_data($con, $sql_get_winners);

if (!empty($winners)) {
    foreach ($winners as $key => $value) {
        $sql_update_stuff = "UPDATE stuff
                     SET winner = {$winners[$key]['user_id']} WHERE id  = {$winners[$key]['id']}";
        $update_stuff = db_insert_data($con, $sql_update_stuff);

        $recipients[$winners[$key]['email']] = $winners[$key]['name'];
        
        $mailer = new Swift_Mailer($transport);
        $logger = new Swift_Plugins_Loggers_ArrayLogger();
        $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));
        $message = new Swift_Message();
        $message->setSubject("Ваша ставка победила");
        $message->setFrom(['keks@phpdemo.ru' => 'Yeticave']);
        $message->setBcc($recipients);
        $msg_content = include_template('email.php', ['user_name' => $winners[$key]['name'], 'id' => $winners[$key]['id'], 'lot_name' => $winners[$key]['stuff_name']]);
        $message->setBody($msg_content, 'text/html');
        $result = $mailer->send($message);
    }
}
