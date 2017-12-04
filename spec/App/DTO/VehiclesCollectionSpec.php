<?php

namespace spec\App\DTO;

use App\DTO\VehiclesCollection;
use App\Entity\Vehicle;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VehiclesCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(VehiclesCollection::class);
    }

    function it_allows_to_add_new_vehicle(Vehicle $vehicle)
    {
        $this->add($vehicle);
    }

    function it_retuns_number_of_all_items(Vehicle $vehicle)
    {
        $this->count()->shouldReturn(0);

        $this->add($vehicle);
        $this->count()->shouldReturn(1);
    }

    function it_returns_all_items_as_array(Vehicle $vehicle)
    {
        $this->add($vehicle);

        $result = $this->getAll();
        $result->shouldBeArray();
        $result->shouldHaveCount(1);
    }
}
