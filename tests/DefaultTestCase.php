<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class DefaultTestCase extends TestCase
{
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }
    
    public function testBootstrap(): void
    {
        $this->assertEquals(1, require_once  __DIR__ . '/../src/bootstrap.php');
    }
    
    public function formatProductArray(int $id, int $duration, string $start, int $places): array
    {
        return [
            'product_id'                   => $id,
            'activity_duration_in_minutes' => $duration,
            'activity_start_datetime'      => $start,
            'places_available'             => $places
        ];
    }
    
    public function formatOutputArray(int $id, array $availableTimes): array
    {
        return [
            'product_id'           => $id,
            'available_starttimes' => $availableTimes
        ];
    }
}
