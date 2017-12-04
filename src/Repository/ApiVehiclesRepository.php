<?php
namespace App\Repository;


use App\DTO\VehiclesCollection;
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

}
