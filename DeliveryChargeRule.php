<?php

class DeliveryChargeRule
{
    public int $rangeStart;
    public int $rangeEnd;
    public int $price;

    /**
     * @param int $rangeStart
     * @param int $rangeEnd
     * @param int $price
     */
    public function __construct(int $rangeStart, int $rangeEnd, int $price)
    {
        $this->rangeStart = $rangeStart;
        $this->rangeEnd = $rangeEnd;
        $this->price = $price;
    }
}