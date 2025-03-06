<?php

namespace App\Helpers;

/**
 * Хелпер для работы с кодами регионов.
 * Форматирует код региона, чтобы он был в нужном виде.
 */
class RegionCodeHelper
{
    /**
     * Приводит код региона к нужному формату (добавляет ноль в начале, если нужно).
     *
     * @param string $text Введённый пользователем код региона.
     *
     * @return string Отформатированный код или сообщение об ошибке.
     */
    public static function formatCode(string $text): string
    {
        if (!is_numeric($text)) {
            return 'Пожалуйста, введите числовой код региона.';
        }

        return str_pad($text, 2, '0', STR_PAD_LEFT);
    }
}
