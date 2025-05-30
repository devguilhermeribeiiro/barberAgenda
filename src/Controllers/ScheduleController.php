<?php

namespace BarberAgenda\Controllers;

use BarberAgenda\Dto\ScheduleRequestDto;
use BarberAgenda\Services\ScheduleService;

class ScheduleController {
    private ScheduleService $scheduleService;

    public function __construct(ScheduleService $scheduleServicsche) {
        $this->scheduleService = $scheduleServicsche;
    }

    public function index(): string {
        $data = $this->scheduleService->getAll();
        $response = json_encode($data);

        return $response;
    }

    public function create(string $requestBody): string {
        if (!json_validate($requestBody)) {
            http_response_code(422);

            return json_encode(["error" => "the request body must contains a valid JSON"]);
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

        http_response_code(201);
        return json_encode($response);
    }

    public function show($id): string {
        $data = $this->scheduleService->getById($id);
        $response = json_encode($data);

        return $response;
    }

    public function update(string $requestBody): string {
        if (!json_validate($requestBody)) {
            http_response_code(422);

            return json_encode(["error" => "the request body must contains a valid JSON"]);
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

        http_response_code(200);
        return json_encode($response);
    }
}