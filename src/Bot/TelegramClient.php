<?php

namespace App\Bot;

/**
 * Класс для работы с API Telegram
 */
class TelegramClient
{
    /** @var string Токен бота Telegram */
    protected string $token;

    /** @var string Базовый URL API Telegram */
    protected string $apiUrl;

    /**
     * Конструктор класса. Инициализирует токен и URL API.
     */
    public function __construct()
    {
        $this->token = $_ENV['TELEGRAM_BOT_TOKEN'];
        $this->apiUrl = "https://api.telegram.org/bot{$this->token}/";
    }

    /**
     * Отправляет сообщение в чат
     *
     * @param int $chatId ID чата, куда отправляется сообщение
     * @param string $text Текст сообщения
     * @return array Ответ API Telegram
     */
    public function sendMessage(int $chatId, string $text): array
    {
        return $this->request('sendMessage', [
            'chat_id' => $chatId,
            'text' => $text
        ]);
    }

    /**
     * Выполняет запрос к API Telegram
     *
     * @param string $method Метод API (например, 'sendMessage')
     * @param array $params Параметры запроса
     * @return array Ответ API в виде массива
     */
    private function request(string $method, array $params = []): array
    {
        $url = $this->apiUrl . $method;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if (!empty($params)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("Ошибка cURL: $error");
        }

        return json_decode($response, true) ?? [];
    }
}
