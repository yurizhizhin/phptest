<?php

namespace app\services\calculate;

use yii\base\BaseObject;

/**
 * @class CalculateService
 * @package app\services\calculate
 */
class CalculateService extends BaseObject implements CalculateInterface
{
    /**
     * @var array $stepSize Величина шага (в км)
     */
    public array $stepParams;

    /**
     * @var float $distance Расстояние для расчета
     */
    public float $distance;

    /**
     * {@inheritDoc}
     */
    public function calculate(): float
    {
        $result = 0;

        $calculatedDistance = 0;

        $stepsCount = count($this->stepParams);

        for ($step = 0; $step < $stepsCount; $step++) {
            $stepParam = $this->stepParams[$step];
            $prevStepParam = $this->stepParams[$step - 1] ?? null;

            if ($this->distance >= $stepParam['distance']) {
                $calculatedDistance += $stepParam['distance'];

                if (!isset($this->stepParams[$step + 1])) {
                    $this->calculateLastStep($result, $calculatedDistance, $stepParam['price']);
                } else {
                    $result += ($stepParam['distance'] - ($prevStepParam ? $prevStepParam['distance'] : 0)) * $stepParam['price'];
                }
            } else {
                $this->calculateLastStep($result, $calculatedDistance, $stepParam['price']);

                break;
            }
        }

        return round($result,2);
    }

    /**
     * Рассчитывает цену остаточного расстояния
     *
     * @param float $result
     * @param float $calculatedDistance
     * @param float $price
     * @return void
     */
    private function calculateLastStep(float &$result, float $calculatedDistance, float $price)
    {
        $result += ($this->distance - ($calculatedDistance ?? 0)) * $price;
    }
}