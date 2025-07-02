<?php

namespace Jitendra\AcmeBasketApp;

/**
 * Interface that defines the structure for any shopping basket implementation.
 */
interface BasketInterface
{
    /**
     * Adds a product to the basket by its product code.
     *
     * @param string $productCode
     */
    public function add(string $productCode): void;

    /**
     * Returns the total cost of the basket including products, delivery, and offers.
     *
     * @return float
     */
    public function total(): float;
}

