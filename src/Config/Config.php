<?php

namespace App\Config;

use Symfony\Component\Dotenv\Dotenv;

/**
 * Класс для загрузки конфигурации из .env файла.
 */
class Config
{
    /**
     * @var array Конфигурационные параметры.
     */
    private array $config;

    /**
     * Конструктор загружает переменные окружения из .env файла.
     *
     * @throws \Exception Если .env файл не найден или не загружен.
     */
    public function __construct()
    {
        $dotenv = new Dotenv();

        $envPath = __DIR__ . '/../../.env';
        if (!file_exists($envPath)) {
            throw new \Exception("Файл .env не найден по пути: $envPath");
        }

        $dotenv->load($envPath);

        $this->config = [
            'botToken' => $_ENV['TELEGRAM_BOT_TOKEN'] ?? null,
            'domain' => $_ENV['DOMAIN'] ?? null,
        ];
    }

    /**
     * Получает значение конфигурационного параметра по ключу.
     *
     * @param string $key Название параметра.
     * @return mixed Значение параметра или null, если не найдено.
     */
    public function get(string $key): mixed
    {
        return $this->config[$key] ?? null;
    }
}
