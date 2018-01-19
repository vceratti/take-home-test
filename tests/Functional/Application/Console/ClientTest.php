<?php

namespace Tests\Functional\Application\Console;

use Tests\DefaultTestCase;

class ClientTest extends DefaultTestCase
{
    public function testCliClientCall(): void
    {
        $expectedJson = $this->jsonReturn();
        
        $clientReturnJson = $this->callCliClient();
        
        $this->assertJsonStringEqualsJsonString(
            $expectedJson,
            $clientReturnJson,
            'CLI Client return does\'nt match expected JSON string'
        );
    }
    
    private function callCliClient(): string
    {
        return $this->callClient($this->getArgvMock());
    }
    
    public function testCliClientWithErrors(): void
    {
        /** @noinspection PhpUnusedLocalVariableInspection */
        $argv = $this->getArgvMock();
        $argv[2] = 'error';
        $argv[4] = 'error';
        
        $expectedErrorJson = json_encode([
            'error' => 'DateTime::__construct(): Failed to parse time string (error) at position 0 (e): ' .
                'The timezone could not be found in the database'
        ]);
        
        $this->assertJsonStringEqualsJsonString(
            $expectedErrorJson,
            $this->callClient($argv),
            'CLI Client return does\'nt match expected JSON for exception.'
        );
    }
    
    public function testCliClientWithNoResults(): void
    {
        /** @noinspection PhpUnusedLocalVariableInspection */
        $argv = $this->getArgvMock();
        $argv[4] = 9999999;
        
        $expectedEmptyJson = json_encode([], JSON_PRETTY_PRINT);
        
        $this->assertJsonStringEqualsJsonString(
            $expectedEmptyJson,
            $this->callClient($argv),
            'CLI Client return does\'nt match expected JSON for exception.'
        );
    }
    
    public function jsonReturn(): string
    {
        return json_encode([
            ['product_id' => 197, 'available_starttimes' => ['2017-12-14T13:45']],
            ['product_id' => 536, 'available_starttimes' => ['2017-12-18T03:30']],
            ['product_id' => 523, 'available_starttimes' => ['2017-12-12T12:45']],
            ['product_id' => 473, 'available_starttimes' => ['2017-12-16T14:30']],
            ['product_id' => 43, 'available_starttimes' => ['2017-12-18T21:30']],
            ['product_id' => 913, 'available_starttimes' => ['2017-12-18T17:45', '2017-12-09T09:30']],
            ['product_id' => 98, 'available_starttimes' => ['2017-12-13T21:15']],
            ['product_id' => 236, 'available_starttimes' => ['2017-12-15T13:45']],
            ['product_id' => 340, 'available_starttimes' => ['2017-12-16T08:30']],
            ['product_id' => 40, 'available_starttimes' => ['2017-12-10T19:30']],
            ['product_id' => 490, 'available_starttimes' => ['2017-12-11T23:15']],
            ['product_id' => 763, 'available_starttimes' => ['2017-12-18T12:30']],
            ['product_id' => 112, 'available_starttimes' => ['2017-12-12T03:00']]
        ], JSON_PRETTY_PRINT);
    }
    
    private function getArgvMock(): array
    {
        return [
            'client.php',
            'http://www.mocky.io/v2/58ff37f2110000070cf5ff16',
            '2017-12-09T09:00',
            '2017-12-19T19:00',
            '37'
        ];
    }
    
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param array $argv
     *
     * @return string
     *
     */
    private function callClient(/** @noinspection PhpUnusedParameterInspection */ array $argv): string
    {
        ob_start();
        require __DIR__ . '/../../../../public/client.php';
        $clientResponse = ob_get_contents();
        ob_end_clean();
        
        return $clientResponse;
    }
}
