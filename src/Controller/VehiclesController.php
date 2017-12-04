<?php

namespace App\Controller;

use App\DTO\VehiclesCollection;
use App\Repository\ApiVehiclesRepository;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VehiclesController extends Controller
{
    public function postVehicle(Request $request, ApiVehiclesRepository $vehiclesRepository)
    {
        $data = \GuzzleHttp\json_decode($request->getContent(), true);

        if (!isset($data['modelYear']) || !isset($data['manufacturer']) || !isset($data['model'])) {
            $result = new VehiclesCollection();
        } else {
            $result = $vehiclesRepository->find($data['modelYear'], $data['manufacturer'], $data['model']);
        }

        $serializer = $this->container->get('jms_serializer');
        $context = SerializationContext::create()->setGroups(['basic']);
        $result = $serializer->serialize($result, 'json', $context);

        return new Response($result);
    }

    public function findVehicle(string $year, string $manufacturer, string $model, ApiVehiclesRepository $vehiclesRepository)
    {
        $result = $vehiclesRepository->find($year, $manufacturer, $model);

        $serializer = $this->container->get('jms_serializer');
        $context = SerializationContext::create()->setGroups(['basic']);
        $result = $serializer->serialize($result, 'json', $context);

        return new Response($result);
    }
}
