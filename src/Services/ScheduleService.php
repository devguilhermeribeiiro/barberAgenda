<?php

namespace BarberAgenda\Services;

use BarberAgenda\Dto\ScheduleRequestDto;
use BarberAgenda\Dto\ScheduleResponseDto;
use BarberAgenda\Entity\Schedule;
use BarberAgenda\Repository\ScheduleRepository;

class ScheduleService {
    private ScheduleRepository $scheduleRepository;

    public function __construct($scheduleRepository) {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function getAll() : array {
        return $this->scheduleRepository->findAll();
    }

    public function getById($id): ScheduleResponseDto {
        return $this->scheduleRepository->findById($id);
    }

    public function create(ScheduleRequestDto $request): ScheduleResponseDto {
        $schedule = new Schedule(
            $request->getService(),
            $request->getBarber(),
            $request->getDate(),
            $request->getHour()
        );

        return $this->scheduleRepository->save($schedule);
    }
    
    public function update(ScheduleRequestDto $request): ScheduleResponseDto {
        $schedule = new Schedule(
            $request->getService(),
            $request->getBarber(),
            $request->getDate(),
            $request->getHour()
        );

        return $this->scheduleRepository->update($schedule, $request->getId());
    }
    
    public function destroy($id): ScheduleResponseDto {
        return $this->scheduleRepository->destroy($id);
    }
}