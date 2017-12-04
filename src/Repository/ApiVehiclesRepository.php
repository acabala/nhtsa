<?php
namespace App\Repository;


use App\DTO\VehiclesCollection;
use App\Entity\RatedVehicle;
use App\Entity\Vehicle;
use GuzzleHttp\ClientInterface;

class ApiVehiclesRepository implements VehiclesRepository
{
    /** @var  ClientInterface */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function find(string $year, string $manufacturer, string $model) : VehiclesCollection
    {
        $uri = sprintf('modelyear/%s/make/%s/model/%s?format=json', $year, $manufacturer, $model);
        $query = $this->client->request('get', $uri);
        $queryResult = \GuzzleHttp\json_decode($query->getBody()->getContents(),true);

        $collection = new VehiclesCollection();
        foreach ($queryResult['Results'] as $result) {
            $collection->add(new Vehicle($result['VehicleId'], $result['VehicleDescription']));
        }

        return $collection;
    }

    public function findWithRating(string $year, string $manufacturer, string $model): VehiclesCollection
    {
        $vehicles = $this->find($year, $manufacturer, $model);
        $collection = new VehiclesCollection();

        /** @var Vehicle $vehicle */
        foreach ($vehicles->getAll() as $vehicle) {
            $uri = sprintf('VehicleId/%s?format=json', $vehicle->getId());
            $query = $this->client->request('get', $uri);
            $queryResult = \GuzzleHttp\json_decode($query->getBody()->getContents(),true);

            $collection->add(new RatedVehicle($vehicle->getId(), $vehicle->getDescription(), $queryResult['Results'][0]['OverallRating']));
        }

        return $collection;
    }

}
