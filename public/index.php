<?php

/**
 * Основной входной скрипт бота Telegram.
 *
 * Подключает автозагрузку, принимает входящие сообщения от Telegram API
 * и передаёт их обработчику сообщений.
 */

require __DIR__ . '/vendor/autoload.php';

use App\Bot\MessageHandler;
use App\Bot\TelegramClient;
use App\Services\CommandService;
use App\Services\TextService;
use App\Services\RegionService;

/**
 * Получение данных из запроса Telegram API.
 *
 * @var string|false $data JSON-данные из входящего запроса.
 */
$data = file_get_contents("php://input");

/**
 * Декодирование JSON в массив.
 *
 * @var array|null $message Декодированное сообщение или null, если JSON некорректен.
 */
$message = json_decode($data, true);

/**
 * Проверка наличия сообщения в данных.
 * Если сообщение отсутствует, скрипт завершает выполнение.
 */
if (!$message || !isset($message['message'])) {
    exit;
}

/**
 * Создание экземпляров сервисов для обработки сообщений.
 */
$telegramClient = new TelegramClient();
$regionService = new RegionService();
$commandService = new CommandService($telegramClient);
$textService = new TextService($regionService, $telegramClient);
$messageHandler = new MessageHandler($commandService, $textService, $telegramClient);

/**
 * Обработка входящего сообщения.
 */
$messageHandler->getMessage($message);
