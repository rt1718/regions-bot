<?php

namespace App\Services;

use App\Bot\TelegramClient;
use App\Config\Regions;
use App\Helpers\RegionCodeHelper;

/**
 * Отвечает за обработку текстовых сообщений — кодов регионов.
 */
class TextService
{
    /** @var RegionService Сервис для работы с регионами */
    protected RegionService $regionService;

    protected TelegramClient $telegramClient;

    /**
     * Создаёт сервис и передаёт ему RegionService.
     *
     * @param RegionService $regionService Сервис, который отвечает за регионы.
     */
    public function __construct(RegionService $regionService, TelegramClient $telegramClient)
    {
        $this->regionService = $regionService;
        $this->telegramClient = $telegramClient;
    }

    /**
     * Достаёт текст из сообщения (если он есть).
     *
     * @param array $message Данные сообщения из Telegram API.
     *
     * @return string|null Текст сообщения или null, если его нет.
     */
    public function get(array $message): ?string
    {
        return $message['message']['text'] ?? null;
    }

    /**
     * Обрабатывает код региона из сообщения и возвращает его название.
     *
     * @param array $message Данные сообщения из Telegram API.
     *
     * @return string Название региона или сообщение об ошибке.
     */
    public function regionHandle(array $message): void
    {
        $chatId = $message['message']['chat']['id'];
        $text = $this->get($message);
        $formattedCode = RegionCodeHelper::formatCode($text);

        if (!is_numeric($formattedCode)) {
            $this->telegramClient->sendMessage($chatId, $formattedCode);
            return;
        }

        $response = $this->regionService->getRegionByCode($formattedCode);
        $this->telegramClient->sendMessage($chatId, $response);
    }
}
