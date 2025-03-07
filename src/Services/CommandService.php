<?php

namespace App\Services;

use App\Bot\TelegramClient;

/**
 * Класс для обработки команд из сообщений Telegram.
 */
class CommandService
{
    /** @var TelegramClient Клиент для работы с Telegram API */
    protected TelegramClient $telegramClient;

    /**
     * Конструктор класса.
     *
     * @param TelegramClient $telegramClient Экземпляр клиента Telegram.
     */
    public function __construct(TelegramClient $telegramClient)
    {
        $this->telegramClient = $telegramClient;
    }

    /**
     * Получает текст команды из сообщения.
     *
     * @param array $message Сообщение из Telegram API.
     *
     * @return string|null Возвращает текст команды или null, если его нет.
     */
    public function get(array $message): ?string
    {
        return $message['message']['text'] ?? null;
    }

    /**
     * Обрабатывает команду и отправляет ответ пользователю.
     *
     * @param array $message Сообщение из Telegram API.
     *
     * @return void
     */
    public function command(array $message): void
    {
        $chatId = $message['message']['chat']['id'];
        $text = $message['message']['text'] ?? '';

        $responseText = match ($text) {
            '/start' => 'Привет! Напиши код региона.',
            '/help' => 'Отправь код региона (например, 01).',
            default => 'Неизвестная команда.'
        };

        $this->telegramClient->sendMessage($chatId, $responseText);
    }
}
