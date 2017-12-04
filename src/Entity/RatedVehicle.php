<?php
namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class RatedVehicle extends Vehicle
{
    /**
     * @Serializer\Expose()
     * @Serializer\Groups({"rating"})
     * @Serializer\SerializedName("CrashRating")
     */
    protected $rating;

    public function __construct($id, $description, $rating)
    {
        $this->rating = $rating;
        parent::__construct($id, $description);
    }

    /**
     * @return string
     */
    public function getRating()
    {
        return $this->rating;
    }
}
