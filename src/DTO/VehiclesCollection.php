<?php
namespace App\DTO;

use App\Entity\Vehicle;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class VehiclesCollection
{
    /**
     * @Serializer\Expose()
     * @Serializer\Groups({"basic"})
     * @Serializer\SerializedName("Results")
     */
    protected $items = [];

    public function add(Vehicle $vehicle) : void
    {
        $this->items[] = $vehicle;
    }

    /**
     * @Serializer\VirtualProperty()
     * @Serializer\Groups({"basic"})
     * @Serializer\SerializedName("Count")
     */
    public function count() : int
    {
        return count($this->items);
    }

    public function getAll() : array
    {
        return $this->items;
    }
}
