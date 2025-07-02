<?php

namespace Jitendra\AcmeBasketApp;

use InvalidArgumentException;

/**
 * Implements the shopping basket logic including product management,
 * delivery rules, and offer handling.
 */
class Basket implements BasketInterface
{
    // Typed properties for PHP 7.4+ or 8+
    private array $catalogue;
    private array $deliveryRules;
    private array $offers;
    private array $items = [];

    /**
     * Basket constructor.
     *
     * @param array $catalogue       Array of productCode => price
     * @param array $deliveryRules   Array of minOrderTotal => deliveryCost
     * @param array $offers          Array of offer rules (e.g., BOGO discounts)
     */
    public function __construct(array $catalogue, array $deliveryRules, array $offers)
    {
        $this->catalogue = $catalogue;
        $this->deliveryRules = $deliveryRules;
        $this->offers = $offers;
    }

    /**
     * Adds a product to the basket by its code.
     *
     * @param string $productCode
     * @throws InvalidArgumentException if the product code is invalid
     */
    public function add(string $productCode): void
    {
        if (!array_key_exists($productCode, $this->catalogue)) {
            throw new InvalidArgumentException("Invalid product code: {$productCode}");
        }

        $this->items[] = $productCode;
    }

    /**
     * Returns the total cost of the basket (to be implemented next).
     *
     * @return float
     */
    public function total(): float
    {
        // We'll implement this in the next step.
        return 0.0;
    }

    /**
     * Returns all items in the basket (used for testing).
     *
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
