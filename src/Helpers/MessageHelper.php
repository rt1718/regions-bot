<?php

namespace App\Helpers;

/**
 * Класс MessageHelper проверяет, что приходит.
 */
class MessageHelper
{
    /**
     * Проверяет, является ли сообщение командой (начинается с "/").
     *
     * @param array $messages Данные сообщения из Telegram API.
     *
     * @return bool Возвращает true, если сообщение является командой, иначе false.
     */
    public static function isCommand(array $messages): bool
    {
        return str_starts_with($messages['message']['text'], '/');
    }
}
