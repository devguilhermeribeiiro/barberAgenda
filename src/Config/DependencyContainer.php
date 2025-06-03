<?php

namespace BarberAgenda\Config;

use BarberAgenda\Dao\ScheduleDao;
use BarberAgenda\Repository\ScheduleRepository;
use BarberAgenda\Services\ScheduleService;

class DependencyContainer
{
    private ScheduleRepository $scheduleRepository;
    private ScheduleService $scheduleService;

    public function __construct()
    {
        $this->scheduleRepository = new ScheduleDao(Database::getConnection());
        $this->scheduleService = new ScheduleService($this->scheduleRepository);
    }

    public function inject()
    {
        return $this->scheduleService;
    }
}
