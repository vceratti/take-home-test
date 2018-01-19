<?php

namespace Tests\Unit\Domain\Product;

use Tests\DefaultTestCase;
use TakeHomeTest\Domain\Product\DateTime;
use TakeHomeTest\Domain\Product\ProductEntity;
use TakeHomeTest\Domain\Product\ProductFilter;

class ProductFilterTest extends DefaultTestCase
{
    private $product;
    
    public function setUp()
    {
        $this->product = new ProductEntity(679, 225, new DateTime('2017-07-07T10:30'), 25);
    }
    
    public function testProductEqualsFilter(): void
    {
        $filter = new ProductFilter(
            $this->product->getStart(),
            $this->product->getEnd(),
            $this->product->getAvailablePlaces()
        );
        
        $this->assertTrue($filter->matchesProduct($this->product), 'Filters not working!');
    }
    
    public function testStartsInInterval(): void
    {
        $startDate = new DateTime('2017-07-07T10:30');
        $endDate = $startDate;
        
        $filter = new ProductFilter($startDate, $endDate, 20);
        
        $this->assertTrue($filter->startsInInterval($this->product), 'Cant filter "start time is inside interval"');
        
        $startDate->addMinutes(20);
        
        $filter = new ProductFilter($startDate, $endDate, 20);
        $this->assertFalse($filter->startsInInterval($this->product), 'Cant filter "start time NOT inside interval"');
    }
    
    public function testEndsInInterval(): void
    {
        $endDate = new DateTime('2017-07-07T10:30');
        $endDate->addMinutes(225);
        $startDate = $endDate;
        
        $filter = new ProductFilter($startDate, $endDate, 20);
        $this->assertTrue($filter->endsInInterval($this->product), 'Cant validate "end time is inside interval"');
        
        $endDate->subMinutes(10);
        $filter = new ProductFilter($startDate, $endDate, 20);
        $this->assertFalse($filter->endsInInterval($this->product), 'Cant validate "end time is NOT inside interval"');
    }
    
    public function testHasEnoughPlaces(): void
    {
        $filter = new ProductFilter($this->product->getStart(), $this->product->getEnd(), 20);
        $this->assertTrue(
            $filter->hasEnoughPlaces($this->product),
            'Cant validate "product has enough places"'
        );
        
        $filter = new ProductFilter($this->product->getStart(), $this->product->getEnd(), 40);
        $this->assertFalse(
            $filter->hasEnoughPlaces($this->product),
            'Cant validate "product has NOT enough places"'
        );
    }
}
