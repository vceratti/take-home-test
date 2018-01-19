<?php

namespace Tests\Unit\Domain\Product;

use Tests\DefaultTestCase;
use TakeHomeTest\Domain\Product\DateTime;
use TakeHomeTest\Domain\Product\ProductEntity;
use TakeHomeTest\Domain\Product\ProductAggregate;
use TakeHomeTest\Domain\Product\ProductFilter;

class ProductAggregateTest extends DefaultTestCase
{
    /** @var ProductAggregate */
    private $productAggregate;
    
    public function setUp()
    {
        $this->productAggregate = new ProductAggregate();
        
        $this->productAggregate->add(new ProductEntity(666, 225, new DateTime('2017-07-07T10:30'), 25));
        $this->productAggregate->add(new ProductEntity(666, 225, new DateTime('2017-07-07T10:30'), 6));
        $this->productAggregate->add(new ProductEntity(666, 225, new DateTime('2017-07-07T11:30'), 40));
        $this->productAggregate->add(new ProductEntity(666, 30, new DateTime('2017-07-07T12:30'), 10));
        $this->productAggregate->add(new ProductEntity(800, 360, new DateTime('2017-07-07T10:30'), 50));
        $this->productAggregate->add(new ProductEntity(801, 120, new DateTime('2017-07-06T11:30'), 50));
        $this->productAggregate->add(new ProductEntity(801, 120, new DateTime('2017-07-07T11:30'), 50));
    }
    
    public function testAggregateToJson()
    {
        $this->assertJsonStringEqualsJsonString(
            $this->productAggregate->toJson(),
            $this->expectedProductListJSON(),
            'Wrong aggregate format or data.'
        );
    }
    
    private function expectedProductListJSON(): string
    {
        return json_encode([
            $this->formatProductArray(666, 225, '2017-07-07T10:30', 31),
            $this->formatProductArray(666, 225, '2017-07-07T11:30', 40),
            $this->formatProductArray(666, 30, '2017-07-07T12:30', 10),
            $this->formatProductArray(800, 360, '2017-07-07T10:30', 50),
            $this->formatProductArray(801, 120, '2017-07-06T11:30', 50),
            $this->formatProductArray(801, 120, '2017-07-07T11:30', 50)
        ]);
    }
    
    public function testFinalOutputJson()
    {
        $filter = new ProductFilter(new DateTime('2017-07-07T05:00'), new DateTime('2017-07-07T16:00'), 30);
        
        $filteredJson = $this->productAggregate->filter($filter)->toResultJSON();
        
        $this->assertJsonStringEqualsJsonString(
            $filteredJson,
            $this->expectedAggregateFilteredListJSON(),
            'Invalid final output data or format.'
        );
    }
    
    private function expectedAggregateFilteredListJSON()
    {
        return json_encode([
            $this->formatOutputArray(666, ['2017-07-07T10:30', '2017-07-07T11:30']),
            $this->formatOutputArray(801, ['2017-07-07T11:30'])
        ]);
    }
}
