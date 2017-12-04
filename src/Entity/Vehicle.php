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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }
}
