<?php

namespace App\Bot;

use App\Config\Config;

/**
 * Этот класс занимается работой с Telegram Webhook.
 * Узнает, что там с вебхуком у бота.
 */
class WebhookHandler
{
    /** @var string Тут хранится токен бота */
    protected string $token;

    /** @var string Адрес API Telegram, к которому будем стучаться */
    protected string $apiUrl;

    /** @var Config Тут живёт конфиг с настройками */
    protected Config $config;

    /**
     * Конструктор класса.
     * Запоминаем конфиг, вытаскиваем из него токен и собираем URL API.
     *
     * @param Config $config Конфиг с настройками бота.
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->token = $this->config->get('botToken');
        $this->apiUrl = "https://api.telegram.org/bot{$this->token}/";
    }

    /**
     * Узнаёт информацию о вебхуке у Telegram.
     *
     * @return array Массив с ответом от Telegram.
     */
    public function getWebhook(): array
    {
        return $this->request('getWebhookInfo');
    }

    /**
     * Отправляет запрос в Telegram API и возвращает ответ.
     *
     * @param string $method Какой метод Telegram API дернуть.
     * @param array $params Какие параметры передать (по умолчанию пусто).
     *
     * @return array Ответ Telegram в виде массива.
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
        curl_close($ch);

        return json_decode($response, true) ?? [];
    }

    /**
     * Устанавливает вебхук.
     *
     * @param string $url Ссылка на файл с обработкой сообщений.
     *
     * @return array Ответ Telegram в виде массива.
     */
    public function setWebhook(string $url): array
    {
        return $this->request('setWebhook', ['url' => $url]);
    }

}
