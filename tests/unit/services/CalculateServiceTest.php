<?php

namespace tests\unit\services;

use app\services\calculate\CalculateService;
use \Codeception\Test\Unit;

/**
 * @class CalculateServiceTest
 * @package tests\unit\services
 */
class CalculateServiceTest extends Unit
{
    /**
     * @return void
     */
    public function testCalculate()
    {
        $service = new CalculateService([
            'stepParams' => [
                [
                    'distance' => 100,
                    'price' => 100,
                ],
                [
                    'distance' => 300,
                    'price' => 80,
                ],
                [
                    'distance' => 600,
                    'price' => 70,
                ],
                [
                    'distance' => 900,
                    'price' => 60,
                ],
            ],
            'distance' => 405,
        ]);

        $this->assertEquals(26350, $service->calculate());

        $this->setValues($service, [
            [
                'distance' => 100,
                'price' => 100,
            ],
            [
                'distance' => 200,
                'price' => 80,
            ],
            [
                'distance' => 400,
                'price' => 70,
            ],
            [
                'distance' => 600,
                'price' => 60,
            ],
        ], 1605);

        $this->assertEquals(50300, $service->calculate());
    }

    protected function setValues(CalculateService &$service, array $stepParams, float $distance)
    {
        $service->stepParams = $stepParams;
        $service->distance = $distance;
    }
}
