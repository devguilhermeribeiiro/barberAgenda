<?php

namespace BarberAgenda\Dto;

class ScheduleRequestDto {


    private ?int $id;
    private string $service;
    private string $barber;
    private string $date;
    private string $hour;

    public function __construct(string $service, string $barber, string $date, string $hour, ?int $id) {
        $this->id = $id;
        $this->service = $service;
        $this->barber = $barber;
        $this->date = $date;
        $this->hour = $hour;
    }

    public function getService(): string {
        return $this->service;
    }

    public function getBarber(): string {
        return $this->barber;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function getHour(): string {
        return $this->hour;
    }

    public function getId(): int {
        return $this->id;
    }
}