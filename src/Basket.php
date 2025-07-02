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
        $subtotal = 0.0;

        // Count how many of each product were added
        $itemCounts = array_count_values($this->items);

        // Apply prices and offers
        foreach ($itemCounts as $code => $quantity) {
            $price = $this->catalogue[$code];

            // Red Widget Offer: Buy 1 get 2nd half price
           if ($code === 'R01' && isset($this->offers[$code])) {
            $fullPriceQty = intdiv($quantity, 2) + ($quantity % 2);
            $halfPriceQty = $quantity - $fullPriceQty;

            // Apply rounding 
            $halfPrice = floor(($price / 2) * 100) / 100;

            $subtotal += ($fullPriceQty * $price) + ($halfPriceQty * $halfPrice);
        } else {
            $subtotal += $price * $quantity;
        }

        }

        // Apply delivery rules based on subtotal
        $deliveryCharge = 0.0;
        foreach ($this->deliveryRules as $minTotal => $charge) {
            if ($subtotal >= $minTotal) {
                $deliveryCharge = $charge;
                break;
            }
        }

        return round($subtotal + $deliveryCharge, 2);
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
