<?php

namespace spec\App\Entity;

use App\Entity\RatedVehicle;
use App\Entity\Vehicle;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RatedVehicleSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(123, 'vehicle description', 5);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RatedVehicle::class);
    }

    function it_should_inherit_vehicle()
    {
        $this->shouldHaveType(Vehicle::class);
    }

    function it_should_return_its_properties()
    {
        $this->getId()->shouldReturn(123);
        $this->getDescription()->shouldReturn('vehicle description');
        $this->getRating()->shouldReturn(5);
    }
}
