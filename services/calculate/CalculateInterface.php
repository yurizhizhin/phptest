<?php

namespace app\services\calculate;

/**
 * @interface CalculateInterface
 * @package app\services\calculate
 */
interface CalculateInterface
{
    /**
     * Высчитывает стоимость перевозки груза с учетом пошагового снижения цены за километр
     *
     * @return float
     */
    public function calculate(): float;
}