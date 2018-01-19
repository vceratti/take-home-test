<?php

namespace TakeHomeTest\Domain\Product;

class ProductFilter
{
    private $start;
    private $end;
    private $places;
    
    public function __construct(DateTime $start, DateTime $end, int $places)
    {
        $this->start = $start;
        $this->end = $end;
        $this->places = $places;
    }
    
    public function matchesProduct(ProductEntity $product): bool
    {
        $match = false;
        
        if ($this->startsInInterval($product) &&
            $this->endsInInterval($product) &&
            $this->hasEnoughPlaces($product)) {
            $match = true;
        }
        
        return $match;
    }
    
    public function startsInInterval(ProductEntity $product): bool
    {
        $start = $product->getStart();
        
        return $this->isInsideInterval($start);
    }
    
    public function endsInInterval(ProductEntity $product): bool
    {
        $end = $product->getEnd();
        
        return $this->isInsideInterval($end);
    }
    
    public function hasEnoughPlaces(ProductEntity $product): bool
    {
        return ($this->places <= $product->getAvailablePlaces());
    }
    
    private function isInsideInterval(DateTime $time): bool
    {
        $isInsideInterval = false;
        if (($time >= $this->start) && ($time <= $this->end)) {
            $isInsideInterval = true;
        }
        
        return $isInsideInterval;
    }
}
