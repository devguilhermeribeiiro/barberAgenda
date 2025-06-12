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

    public function create(): void {
        $requestBody = file_get_contents('php://input');

        if (!json_validate($requestBody)) {
            echo json_encode(["error" => "the request body must contains a valid JSON"]);
        }

        $data = json_decode($requestBody, true);
        print_r($data);

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
        $response = $this->scheduleService->getById($id);

        echo json_encode($response);
    }

    public function update($id): void {
        $requestBody = file_get_contents('php://input');

        if (!json_validate($requestBody)) {
            echo json_encode(["error" => "the request body must contains a valid JSON"]);
        }

        $data = json_decode($requestBody, true);

        $scheduleRequestDto = new ScheduleRequestDto(
            $data["service"],
            $data["barber"],
            $data["date"],
            $data["hour"],
            $id
        );
        
        $response = $this->scheduleService->update($scheduleRequestDto);

        echo json_encode($response);
    }

    public function destroy($id): void {
        $data = $this->scheduleService->destroy($id);
        $response = json_encode(["message" => "Schedule destroyed"]);

        echo $response;
    }
}