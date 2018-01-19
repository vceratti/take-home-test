<?php

use TakeHomeTest\Domain\Product;

try{
    require_once __DIR__ . '/../src/bootstrap.php';
    
    if(count($argv) < 5){
        throw new \Exception('invalid arguments');
    }
    [$file, $url, $start, $end, $places] = $argv;
    
    $client = new TakeHomeTest\Application\Console\Client(
        $url,
        new Product\ProductFilter(new Product\DateTime($start), new Product\DateTime($end), $places),
        new Product\ProductAggregate()
    );
    
    echo $client->getProducts();
}catch (\Exception $e){
    echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
}


