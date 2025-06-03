<?php

namespace BarberAgenda\Repository;

use BarberAgenda\Entity\Schedule;

interface ScheduleRepository {
    public function findAll();

    public function findById(int $id);

    public function save(Schedule $schedule);

    public function update(Schedule $schedule, int $id);

    public function destroy(int $id);
}