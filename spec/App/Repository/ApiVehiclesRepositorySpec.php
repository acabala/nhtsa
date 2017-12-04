<?php

namespace spec\App\Repository;

use App\DTO\VehiclesCollection;
use App\Entity\RatedVehicle;
use App\Entity\Vehicle;
use App\Repository\ApiVehiclesRepository;
use App\Repository\VehiclesRepository;
use GuzzleHttp\ClientInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ApiVehiclesRepositorySpec extends ObjectBehavior
{
    function let(ClientInterface $client)
    {
        $this->beConstructedWith($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ApiVehiclesRepository::class);
    }

    function it_implements_interface()
    {
        $this->shouldImplement(VehiclesRepository::class);
    }

    function it_returns_vehicles_collection(
        ClientInterface $client,
        ResponseInterface $response,
        StreamInterface $stream
    )
    {
        $client->request('get', Argument::any())->willReturn($response);
        $stream->getContents()->willReturn(\GuzzleHttp\json_encode([
            'Count' =>  2,
            'Message' => 'Results returned successfully',
            'Results' => [
                [
                    'VehicleDescription' =>  '2015 Audi A3 4 DR AWD',
                    'VehicleId' =>  9403
                ],
                [
                    'VehicleDescription' =>  '2015 Audi A3 4 DR FWD',
                    'VehicleId' =>  9408
                ]
            ]
        ]));

        $response->getBody()->willReturn($stream);

        $result = $this->find(2015, 'Audi', 'A3');
        $result->shouldHaveType(VehiclesCollection::class);
        $vehicle1 = $result->getAll()[0];
        $vehicle1->shouldHaveType(Vehicle::class);
        $vehicle1->getId()->shouldReturn(9403);
    }

    function it_returns_rated_vehicles_collection(
        ClientInterface $client,
        ResponseInterface $response1,
        StreamInterface $stream1,
        ResponseInterface $response2,
        StreamInterface $stream2
    )
    {
        $client->request('get', Argument::containingString('modelyear'))->willReturn($response1);
        $stream1->getContents()->willReturn(\GuzzleHttp\json_encode([
            'Count' =>  1,
            'Message' => 'Results returned successfully',
            'Results' => [
                [
                    'VehicleDescription' =>  '2015 Audi A3 4 DR AWD',
                    'VehicleId' =>  9403
                ]
            ]
        ]));
        $response1->getBody()->willReturn($stream1);

        $client->request('get', Argument::containingString('VehicleId'))->willReturn($response2);
        $stream2->getContents()->willReturn(\GuzzleHttp\json_encode([
            'Count' =>  1,
            'Message' => 'Results returned successfully',
            'Results' => [
                [
                    'OverallRating' => 5,
                ]
            ]
        ]));

        $response2->getBody()->willReturn($stream2);

        $result = $this->findWithRating(2015, 'Audi', 'A3');
        $result->shouldHaveType(VehiclesCollection::class);
        $vehicle1 = $result->getAll()[0];
        $vehicle1->shouldHaveType(RatedVehicle::class);
        $vehicle1->getId()->shouldReturn(9403);
        $vehicle1->getRating()->shouldReturn(5);
    }
}
