<?php
namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class Vehicle
{
    /**
     * @Serializer\Expose()
     * @Serializer\Groups({"basic"})
     * @Serializer\SerializedName("VehicleId")
     */
    protected $id;

    /**
     * @Serializer\Expose()
     * @Serializer\Groups({"basic"})
     * @Serializer\SerializedName("Description")
     */
    protected $description;

    public function __construct($id, $description)
    {
        $this->id = $id;
        $this->description = $description;
    }
}
