<?php

class Basket
{
    /**
     * @var Product[]
     */
    private array $products;
    /**
     * @var DeliveryChargeRule[]
     */
    private array $deliveryChargeRules;
    /**
     * @var Offer[]
     */
    private array $offers;
    /**
     * @var string[]
     */
    private $codePrices;
    /**
     * @var string[]
     */
    private array $items = [];

    /**
     * @param Product[] $products
     * @param DeliveryChargeRule[] $deliveryChargeRules
     * @param Offer[] $offers
     */
    public function __construct(array $products, array $deliveryChargeRules, array $offers)
    {
        $this->products = $products;
        $this->deliveryChargeRules = $deliveryChargeRules;
        $this->offers = $offers;

        $productCodes = array_map(fn(Product $product) => $product->code, $this->products);
        $productPrices = array_map(fn(Product $product) => $product->price, $this->products);
        $this->codePrices = array_combine($productCodes, $productPrices) ?: [];
    }

    public function add(string $code): self
    {
        $this->items[] = $code;

        return $this;
    }

    public function clear(): self
    {
        $this->items = [];

        return $this;
    }

    public function total(): int
    {
        $productsSum = array_reduce(
            $this->items,
            function (int $acc, string $code) {
                return $acc + $this->codePrices[$code];
            },
            0
        );

        $offerDiscountSum = $this->calculateDiscount();

        $subTotal = $productsSum - $offerDiscountSum;

        $deliveryPrice = $this->calculateDeliveryPrice($subTotal);

        return $subTotal + $deliveryPrice;
    }

    private function calculateDiscount(): int
    {
        $codeCounts = array_count_values($this->items);

        return array_reduce(
            $this->offers,
            function (int $acc, Offer $offer) use ($codeCounts) {
                if (!isset($codeCounts[$offer->targetCode])) {
                    return $acc;
                }

                $discountedCount = floor($codeCounts[$offer->targetCode] / $offer->discountedItemCount);

                return $acc + ceil($this->codePrices[$offer->targetCode] * $discountedCount * $offer->discount);
            },
            0
        );
    }

    private function calculateDeliveryPrice(int $subTotal): int
    {
        foreach ($this->deliveryChargeRules as $chargeRule) {
            if ($subTotal >= $chargeRule->rangeStart && $subTotal < $chargeRule->rangeEnd) {
                return $chargeRule->price;
            }
        }

        return 0;
    }
}