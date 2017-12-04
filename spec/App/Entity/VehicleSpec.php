<?php

namespace spec\App\Entity;

use App\Entity\Vehicle;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VehicleSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(123, 'vehicle description');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Vehicle::class);
    }

    function it_should_return_its_properties()
    {
        $this->getId()->shouldReturn(123);
        $this->getDescription()->shouldReturn('vehicle description');
    }
}
