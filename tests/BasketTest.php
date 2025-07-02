<?php

use PHPUnit\Framework\TestCase;
use Jitendra\AcmeBasketApp\Basket;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Unit tests for the Basket class.
 */
class BasketTest extends TestCase
{
    /**
     * @var array<string, float>
     */
    private array $catalogue;

    /**
     * @var array<int, float>
     */
    private array $deliveryRules;

    /**
     * @var array<string, array<string, mixed>>
     */
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

    public function testBasketWithB01AndG01(): void
{
    $basket = new Basket($this->catalogue, $this->deliveryRules, $this->offers);
    $basket->add('B01');
    $basket->add('G01');

    // $7.95 + $24.95 = $32.90 → < $50 → + $4.95 delivery = 37.85
    $this->assertEquals(37.85, $basket->total());
}

public function testBasketWithTwoR01(): void
{
    $basket = new Basket($this->catalogue, $this->deliveryRules, $this->offers);
    $basket->add('R01');
    $basket->add('R01');

    // First full price: $32.95, second half: $16.48 = $49.43 + $4.95 = 54.38 → rounded = 54.37
    $this->assertEquals(54.37, $basket->total());
}

public function testBasketWithR01AndG01(): void
{
    $basket = new Basket($this->catalogue, $this->deliveryRules, $this->offers);
    $basket->add('R01');
    $basket->add('G01');

    // $32.95 + $24.95 = $57.90 → + $2.95 delivery = 60.85
    $this->assertEquals(60.85, $basket->total());
}

public function testBasketWithThreeR01AndTwoB01(): void
{
    $basket = new Basket($this->catalogue, $this->deliveryRules, $this->offers);
    $basket->add('B01');
    $basket->add('B01');
    $basket->add('R01');
    $basket->add('R01');
    $basket->add('R01');

    // R01: 3 items → 2 full price ($32.95), 1 half price ($16.48)
    // B01: 2 x $7.95
    // Product total: (2×32.95 + 1×16.48 + 2×7.95) = 93.32 → Free delivery
    $this->assertEquals(98.27, $basket->total());
}

}
