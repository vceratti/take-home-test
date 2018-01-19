<?php

namespace TakeHomeTest\Domain\Product;

class ProductEntity
{
    private $uniqueKey;
    private $id;
    private $duration;
    private $start;
    private $availablePlaces;
    private $end;
    
    /**
     * ProductEntity constructor.
     *
     * @param int $id
     * @param int $duration
     * @param \TakeHomeTest\Domain\Product\DateTime $start
     * @param int $availablePlaces
     *
     * @throws \Exception
     */
    public function __construct(int $id, int $duration, DateTime $start, int $availablePlaces)
    {
        $this->uniqueKey = "{$id}_{$start}";
        $this->id = $id;
        $this->duration = $duration;
        $this->start = $start;
        $this->availablePlaces = $availablePlaces;
        
        $this->end = new DateTime($start);
        $this->end->addMinutes($duration);
    }
    
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
    
    public function toArray(): array
    {
        return [
            'product_id'                   => $this->id,
            'activity_duration_in_minutes' => $this->duration,
            'activity_start_datetime'      => "$this->start",
            'places_available'             => $this->availablePlaces
        ];
    }
    
    public function getUniqueKey(): string
    {
        return $this->uniqueKey;
    }
    
    public function addAvailablePlaces(int $places): void
    {
        $this->availablePlaces += $places;
    }
    
    public function getAvailablePlaces(): int
    {
        return $this->availablePlaces;
    }
    
    public function getStart(): DateTime
    {
        return $this->start;
    }
    
    public function getEnd(): DateTime
    {
        return $this->end;
    }
    
    public function getId(): int
    {
        return $this->id;
    }
}
