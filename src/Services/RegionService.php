<?php

namespace App\Services;

/**
 * Сервис для работы с регионами.
 * Позволяет получать название региона по его коду.
 */
class RegionService
{
    /** @var array Список регионов (код => название) */
    protected array $regions;

    /**
     * Загружает список регионов из файла конфигурации.
     */
    public function __construct()
    {
        $this->regions = require __DIR__ . '/../Config/regions.php';
    }

    /**
     * Ищет название региона по его коду.
     *
     * @param string $code Код региона (например, "01" или "67").
     *
     * @return string Название региона или сообщение, если код не найден.
     */
    public function getRegionByCode(string $code): string
    {
        return $this->regions[$code] ?? 'Такого региона нет, попробуйте другой код.';
    }
}
