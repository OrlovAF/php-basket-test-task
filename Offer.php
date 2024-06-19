<?php

class Offer
{
    public string $targetCode;
    public int $discountedItemCount;
    public float $discount;

    /**
     * @param string $targetCode
     * @param int $discountedItemCount
     * @param float $discount
     */
    public function __construct(string $targetCode, int $discountedItemCount, float $discount)
    {
        $this->targetCode = $targetCode;
        $this->discountedItemCount = $discountedItemCount;
        $this->discount = $discount;
    }
}