<?php

namespace TakeHomeTest\Domain\Product;

class DateTime extends \DateTime
{
    public function __toString(): string
    {
        return $this->format('Y-m-d\\TH:i');
    }
    
    /**
     * @param int $minutes
     *
     * @throws \Exception
     */
    public function addMinutes(int $minutes): void
    {
        $this->updateMinutes('add', $minutes);
    }
    
    /**
     * @param int $minutes
     * @throws \Exception
     *
     * @throws \Exception
     */
    public function subMinutes(int $minutes): void
    {
        $this->updateMinutes('sub', $minutes);
    }
    
    /**
     * @param string $operation
     * @param int $minutes
     *
     * @throws \Exception
     */
    private function updateMinutes(string $operation, int $minutes): void
    {
        $this->$operation(new \DateInterval("PT{$minutes}M"));
    }
}
