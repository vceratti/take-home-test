<?php

namespace TakeHomeTest\Application\Console;

use GuzzleHttp;
use TakeHomeTest\Domain\Product\DateTime;
use TakeHomeTest\Domain\Product\ProductEntity;
use TakeHomeTest\Domain\Product\ProductFilter;
use TakeHomeTest\Domain\Product\ProductAggregate;

class Client
{
    private $requestURL;
    private $productFilter;
    private $productAggregate;
    
    public function __construct(string $requestURL, ProductFilter $productFilter, ProductAggregate $productAggregate)
    {
        $this->requestURL = $requestURL;
        $this->productFilter = $productFilter;
        $this->productAggregate = $productAggregate;
    }
    
    public function toJson(): string
    {
        return $this->productAggregate->toResultJSON();
    }
    
    /**
     * @throws \RuntimeException
     * @return string
     */
    public function requestJson(): string
    {
        $guzzleClient = new GuzzleHttp\Client();
        $body = $guzzleClient->get($this->requestURL)->getBody();
        return $body->getContents();
    }
    
    /**
     * @param string $jsonProducts
     *
     * @return \TakeHomeTest\Application\Console\Client
     * @throws \Exception
     */
    public function parseProducts(string $jsonProducts): Client
    {
        $productList = $this->getProductList($jsonProducts);
        
        $this->buildProductAggregate($productList);
        
        return $this;
    }
    
    public function filter(): Client
    {
        $this->productAggregate->filter($this->productFilter);
        
        return $this;
    }
    
    /**
     * @return string
     * @throws \Exception
     */
    public function getProducts(): string
    {
        $this->parseProducts($this->requestJson());
        $this->filter();
        
        return $this->toJson();
    }
    
    private function getProductList(string $jsonProducts): array
    {
        $productList = json_decode($jsonProducts);
        
        return $productList->product_availabilities;
    }
    
    /**
     * @throws \Exception
     * @param array $productList
     */
    private function buildProductAggregate(array $productList): void
    {
        foreach ($productList as $product) {
            /** @var $product \stdClass */
            $this->productAggregate->add(
                new ProductEntity(
                    $product->product_id,
                    $product->activity_duration_in_minutes,
                    new DateTime($product->activity_start_datetime),
                    $product->places_available
                )
            );
        }
    }
}
