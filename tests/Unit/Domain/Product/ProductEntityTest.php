<?php

namespace Tests\Unit\Domain\Product;

use Tests\DefaultTestCase;
use TakeHomeTest\Domain\Product\DateTime;
use TakeHomeTest\Domain\Product\ProductEntity;

class ProductEntityTest extends DefaultTestCase
{
    /** @var \TakeHomeTest\Domain\Product\ProductEntity */
    private $productEntity;
    
    public function setUp()
    {
        $this->productEntity = new ProductEntity(679, 180, new DateTime('2017-07-07T10:30'), 25);
    }
    
    public function testEntityToJson()
    {
        $this->assertJsonStringEqualsJsonString(
            $this->productEntity->toJson(),
            $this->expectedClientsJSON(),
            'Could not retrieve JSON object from ProductEntity'
        );
    }
    
    public function testEntityAddPlaces()
    {
        $this->productEntity->addAvailablePlaces(10);
        
        $this->assertEquals(
            35,
            $this->productEntity->getAvailablePlaces(),
            'Could not add available places to existing Product'
        );
    }
    
    private function expectedClientsJSON(): string
    {
        return json_encode($this->formatProductArray(679, 180, '2017-07-07T10:30', 25));
    }
}
