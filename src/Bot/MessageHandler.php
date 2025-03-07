<?php

namespace App\Bot;

use App\Services\CommandService;
use App\Services\TextService;
use App\Helpers\MessageHelper;

/**
 * Класс MessageHandler обрабатывает входящие сообщения в боте.
 */
class MessageHandler
{
    /** @var CommandService Сервис для обработки команд */
    protected CommandService $commandService;

    /** @var TextService Сервис для обработки текстовых сообщений */
    protected TextService $textService;

    protected TelegramClient $telegramClient;

    /**
     * Конструктор класса.
     *
     * @param CommandService $commandService Сервис для обработки команд.
     * @param TextService $textService Сервис для обработки текстовых сообщений.
     */
    public function __construct(CommandService $commandService, TextService $textService, TelegramClient $telegramClient)
    {
        $this->commandService = $commandService;
        $this->textService = $textService;
        $this->telegramClient = $telegramClient;
    }

    /**
     * Обрабатывает входящее сообщение.
     *
     * @param array $message Данные сообщения из Telegram API.
     */
    public function getMessage(array $message): void
    {
        if (!isset($message['message']['text'])) {
            return;
        }

        if (MessageHelper::isCommand($message)) {
            $response = $this->commandService->command($message);
        } else {
            $response = $this->textService->regionHandle($message);
        }

        $chatId = $message['message']['chat']['id'];
        $this->telegramClient->sendMessage($chatId, $response);
    }

}
