<?php
namespace App\Tests\Entity;

use App\Entity\Measurement;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    #[DataProvider('dataGetFahrenheit')]
    public function testGetFahrenheit(string $celsius, string $expectedFahrenheit): void
    {
        $measurement = new Measurement();
        $measurement->setCelsius($celsius);
        $this->assertEquals((float)$expectedFahrenheit, $measurement->getFahrenheit());
    }

    public static function dataGetFahrenheit(): array
    {
        return [
            ['0', '32'],
            ['-100', '-148'],
            ['50', '122'],
            ['25', '77'],
            ['67', '152.60'],
            ['255', '491.00'],
            ['12', '53.60'],
            ['20', '68.00'],
            ['36', '96.80'],
            ['3', '37.40'],
        ];
    }
}
