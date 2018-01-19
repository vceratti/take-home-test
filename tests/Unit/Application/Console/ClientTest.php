<?php

namespace Tests\Unit\Application\Console;

use TakeHomeTest\Domain\Product\DateTime;
use TakeHomeTest\Domain\Product\ProductAggregate;
use Tests\DefaultTestCase;
use TakeHomeTest\Application\Console\Client;
use TakeHomeTest\Domain\Product\ProductFilter;

class ClientTest extends DefaultTestCase
{
    private $filter;
    private $productAggregate;
    private $productList;
    private $client;
    
    public function setUp()
    {
        $this->filter = new ProductFilter(new DateTime('2017-11-20T09:30'), new DateTime('2017-11-23T19:30'), 10);
        $this->productAggregate = new ProductAggregate();
        $this->productList = json_encode([
            'product_availabilities' =>
                [
                    $this->formatProductArray(123, 255, '2017-11-20T10:30', 30),
                    $this->formatProductArray(123, 255, '2017-07-07T11:30', 30),
                    $this->formatProductArray(500, 30, '2017-11-21T10:30', 10),
                    $this->formatProductArray(600, 30, '2017-11-21T10:30', 5),
                ]
        ]);
        
        $mockUrl = 'https://jsonplaceholder.typicode.com/todos/1';
        $this->client = new Client($mockUrl, $this->filter, $this->productAggregate);
    }
    
    public function testDataRequestClient()
    {
        $this->assertJsonStringEqualsJsonString(
            json_encode(json_decode($this->client->requestJson()), JSON_PRETTY_PRINT),
            json_encode([
                'userId'    => 1,
                'id'        => 1,
                'title'     => 'delectus aut autem',
                'completed' => false
            ], JSON_PRETTY_PRINT),
            'Client request returns invalid data or format'
        );
    }
    
    public function testClientWithFilter()
    {
        $this->assertJsonStringEqualsJsonString(
            $this->client->parseProducts($this->productList)->filter()->toJson(),
            json_encode([
                $this->formatOutputArray(123, ['2017-11-20T10:30']),
                $this->formatOutputArray(500, ['2017-11-21T10:30']),
            ])
        );
    }
}
