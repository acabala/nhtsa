<?php

namespace App\Controller;

use App\Repository\ApiVehiclesRepository;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VehiclesController extends Controller
{

    public function postVehicle()
    {
        return new JsonResponse([]);
    }

    public function findVehicle(string $year, string $mark, string $model, ApiVehiclesRepository $vehiclesRepository)
    {
        $result = $vehiclesRepository->find($year, $mark, $model);

        $serializer = $this->container->get('jms_serializer');
        $context = SerializationContext::create()->setGroups(['basic']);
        $result = $serializer->serialize($result, 'json', $context);

        return new Response($result);
    }
}
