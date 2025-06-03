<?php

namespace BarberAgenda\Controllers;

use BarberAgenda\Dto\ScheduleRequestDto;
use BarberAgenda\Services\ScheduleService;

class ScheduleController {
    private ScheduleService $scheduleService;

    public function __construct(ScheduleService $scheduleServicsche) {
        $this->scheduleService = $scheduleServicsche;
    }

    public function index(): void {
        $data = $this->scheduleService->getAll();
        $response = json_encode($data);

        echo $response;
    }

    public function create(string $requestBody): void {
        if (!json_validate($requestBody)) {
            echo json_encode(["error" => "the request body must contains a valid JSON"]);
        }

        $data = json_decode($requestBody, true);

        $scheduleRequestDto = new ScheduleRequestDto(
            $data["service"],
            $data["barber"],
            $data["date"],
            $data["hour"],
            null
        );
        
        $response = $this->scheduleService->create($scheduleRequestDto);

        echo json_encode($response);
    }

    public function show($id): void {
        $data = $this->scheduleService->getById($id);
        $response = json_encode($data);

        echo $response;
    }

    public function update(string $requestBody): void {
        if (!json_validate($requestBody)) {
            echo json_encode(["error" => "the request body must contains a valid JSON"]);
        }

        $data = json_decode($requestBody, true);

        $scheduleRequestDto = new ScheduleRequestDto(
            $data["service"],
            $data["barber"],
            $data["date"],
            $data["hour"],
            $data["id"],
        );
        
        $response = $this->scheduleService->update($scheduleRequestDto);

        echo json_encode($response);
    }

    public function destroy($id): void {
        $data = $this->scheduleService->destroy($id);
        $response = json_encode([["message" => "Schedule destroyed"] => $data]);

        echo $response;
    }
}