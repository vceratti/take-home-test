<?php

namespace TakeHomeTest\Domain\Product;

class ProductAggregate
{
    /** @var array \TakeHomeTest\Domain\Product\ProductEntity */
    private $products = [];
    
    public function add(ProductEntity $product): void
    {
        $hash = $product->getUniqueKey();
        
        if (isset($this->products[$hash])) {
            $product = $this->update($this->products[$hash], $product);
        }
        
        $this->products[$product->getUniqueKey()] = $product;
    }
    
    public function toJson(): string
    {
        $productList = [];
        foreach ($this->products as $product) {
            /** @var $product \TakeHomeTest\Domain\Product\ProductEntity */
            $productList[] = $product->toArray();
        }
        
        return json_encode($productList);
    }
    
    public function filter(ProductFilter $filter): ProductAggregate
    {
        foreach ($this->products as $hash => $product) {
            /** @var $product \TakeHomeTest\Domain\Product\ProductEntity */
            if (!$filter->matchesProduct($product)) {
                unset($this->products[$hash]);
            }
        }
        
        return $this;
    }
    
    private function update(ProductEntity $existingProduct, ProductEntity $newProduct): ProductEntity
    {
        $existingProduct->addAvailablePlaces($newProduct->getAvailablePlaces());
        
        return $existingProduct;
    }
    
    public function toResultJSON(): string
    {
        $output = [];
        foreach ($this->products as $product) {
            /** @var $product \TakeHomeTest\Domain\Product\ProductEntity */
            $id = $product->getId();
            $output[$id]['product_id'] = $id;
            $output[$id]['available_starttimes'][] = "{$product->getStart()}";
        }
        
        $finalOutput = [];
        foreach ($output as $item) {
            $finalOutput[] = $item;
        }
        
        return json_encode($finalOutput, JSON_PRETTY_PRINT);
    }
}
