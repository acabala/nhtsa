<?php

namespace App\Controller;

use App\DTO\VehiclesCollection;
use App\Repository\ApiVehiclesRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VehiclesController extends Controller
{
    /** @var SerializerInterface */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function postVehicle(Request $request, ApiVehiclesRepository $vehiclesRepository)
    {
        $data = \GuzzleHttp\json_decode($request->getContent(), true);

        if (!isset($data['modelYear']) || !isset($data['manufacturer']) || !isset($data['model'])) {
            $result = new VehiclesCollection();
        } else {
            $result = $vehiclesRepository->find($data['modelYear'], $data['manufacturer'], $data['model']);
        }

        $context = SerializationContext::create()->setGroups(['basic']);
        $result = $this->serializer->serialize($result, 'json', $context);

        return new Response($result);
    }

    public function findVehicle(string $year, string $manufacturer, string $model, Request $request, ApiVehiclesRepository $vehiclesRepository)
    {
        $withRating = $request->get('withRating');

        if ($withRating === 'true') {
            $result = $vehiclesRepository->findWithRating($year, $manufacturer, $model);
            $context = SerializationContext::create()->setGroups(['basic', 'rating']);
        } else {
            $result = $vehiclesRepository->find($year, $manufacturer, $model);
            $context = SerializationContext::create()->setGroups(['basic']);
        }

        $result = $this->serializer->serialize($result, 'json', $context);

        return new Response($result);
    }
}
