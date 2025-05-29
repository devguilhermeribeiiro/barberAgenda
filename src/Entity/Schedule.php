<?php

namespace BarberAgenda\Entity;

class Schedule {
    private string $service;
    private string $barber;
    private string $date;
    private string $hour;

    public function __construct(string $service, string $barber, string $date, string $hour) {
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

    public function getdate() : string {
        return $this->date;
    }

    public function getHour(): string {
        return $this->hour;
    }

}