<?php

class Product
{
    public string $name;
    public string $code;
    public int $price;

    /**
     * @param string $name
     * @param string $code
     * @param int $price
     */
    public function __construct(string $name, string $code, int $price)
    {
        $this->name = $name;
        $this->code = $code;
        $this->price = $price;
    }
}