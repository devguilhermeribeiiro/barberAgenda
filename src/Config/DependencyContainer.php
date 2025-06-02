<?php

namespace BarberAgenda\Config;

use BarberAgenda\Controllers\ScheduleController;
use BarberAgenda\Repository\ScheduleRepository;
use BarberAgenda\Services\ScheduleService;

class DependencyContainer
{
    public static function inject(): ScheduleService {
        $repository = new ScheduleRepository;
        $service = new ScheduleService($repository);

        return $service;
    }
}
