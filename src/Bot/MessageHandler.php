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

    /**
     * Конструктор класса.
     *
     * @param CommandService $commandService Сервис для обработки команд.
     * @param TextService $textService Сервис для обработки текстовых сообщений.
     */
    public function __construct(CommandService $commandService, TextService $textService)
    {
        $this->commandService = $commandService;
        $this->textService = $textService;
    }

    /**
     * Обрабатывает входящее сообщение.
     *
     * @param array $messages Данные сообщения из Telegram API.
     */
    public function getMessage(array $messages): void
    {
        if (MessageHelper::isCommand($messages)) {
            $this->commandService->get($messages);
            return;
        }

        $this->textService->get($messages);
    }
}
