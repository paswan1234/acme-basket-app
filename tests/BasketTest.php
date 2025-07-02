<?php

use PHPUnit\Framework\TestCase;
use Jitendra\AcmeBasketApp\Basket;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Unit tests for the Basket class.
 */
class BasketTest extends TestCase
{
    private array $catalogue;
    private array $deliveryRules;
    private array $offers;

    protected function setUp(): void
    {
        // Define available products
        $this->catalogue = [
            'R01' => 32.95,
            'G01' => 24.95,
            'B01' => 7.95,
        ];

        // Delivery thresholds: minimum order => delivery charge
        $this->deliveryRules = [
            90 => 0.00,
            50 => 2.95,
            0  => 4.95,
        ];

        // Offers like "buy 1 get 2nd half price"
        $this->offers = [
            'R01' => [
                'type' => 'second_half_price',
                'quantity' => 2,
            ],
        ];
    }

    public function testAddValidProduct(): void
    {
        $basket = new Basket($this->catalogue, $this->deliveryRules, $this->offers);
        $basket->add('R01');

        $this->assertSame(['R01'], $basket->getItems());
    }

    public function testAddInvalidProductThrowsException(): void
    {
        $basket = new Basket($this->catalogue, $this->deliveryRules, $this->offers);

        $this->expectException(InvalidArgumentException::class);
        $basket->add('INVALID');
    }
}
