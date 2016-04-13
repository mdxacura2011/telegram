<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 07.04.16
 * Time: 22:11
 */
/*define('BOT_TOKEN', '211209495:AAFKJkIXGG49hsX4-kpKolOoFUXkWAe7jPs'); //token
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/'); //полный путь

$update = file_get_contents(API_URL . 'getUpdates'); //получаем данные

$decode = json_decode($update, true); //декодируем json,  преобразуем в ассоциативный массив

$count = count($decode['result']) - 1; //последний элемент массива result

$message = htmlspecialchars($decode['result'][$count]['message']['text']); //получаем текст сообщения и преобразуем специальные символы в HTML-сущности
$chat_id = $decode['result'][$count]['message']['chat']['id']; //получаем id пользователя который написал сообщение

file_get_contents(API_URL . 'sendMessage?chat_id=' . $chat_id .'&text=' . $message);*/

class TelegramMessage

{
    const BOT_TOKEN = '211209495:AAFKJkIXGG49hsX4-kpKolOoFUXkWAe7jPs';
    const API_URL = 'https://api.telegram.org/bot';

    protected $message;
    protected $chat_id;

    protected function getData()
    {
        $update = file_get_contents(self::API_URL . self::BOT_TOKEN . '/getUpdates');

        $decode = json_decode($update, true);

        if (!isset($decode)) {
            return;
        }

        return $decode;
    }

    protected function checkingData()
    {
        $arr = $this->getData();

       if (!empty($arr)) {

        $count = count($arr['result']) - 1;

        $this->message = htmlspecialchars($arr['result'][$count]['message']['text']);

        $this->chat_id = $arr['result'][$count]['message']['chat']['id'];
       }

    }

    public function output()
    {
        if(empty($this->chat_id) || empty($this->message)) {
            return;
        }
        
        $this->checkingData();
        file_get_contents(self::API_URL . self::BOT_TOKEN . '/sendMessage?chat_id=' . $this->chat_id .'&text=' . $this->message);
    }
}

$object = new TelegramMessage();

$object->output();
