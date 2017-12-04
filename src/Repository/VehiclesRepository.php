<?php

namespace App\Repository;


use App\DTO\VehiclesCollection;

interface VehiclesRepository
{
    public function find(string $year, string $manufacturer, string $model) : VehiclesCollection;
}
