<?php

namespace BarberAgenda\Dao;

use BarberAgenda\Dto\ScheduleResponseDto;
use BarberAgenda\Entity\Schedule;
use BarberAgenda\Repository\ScheduleRepository;
use PDO;

class ScheduleDao implements ScheduleRepository
{
    private $conn;
    
    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function findAll(): array
    {
        $stmt = $this->conn->query("SELECT count(*) FROM schedules")->fetch();

        if ($stmt["count"] == 0) {
            return ["Status" => "No data found"];
        }

        $stmt = $this->conn->query("SELECT * FROM schedules");
        $rs = $stmt->fetch(PDO::FETCH_ASSOC);

        [$this->conn, $stmt] = null;

        return $rs;
    }

    public function findById(int $id): ScheduleResponseDto {
        $stmt = $this->conn->prepare("SELECT * FROM schedules WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $rs = $stmt->fetchObject("ScheduleRespondeDto");

        [$this->conn, $stmt] = null;

        return $rs;
    }

    public function save(Schedule $schedule): ScheduleResponseDto {
        $stmt = $this->conn->prepare("INSERT INTO schedules (service, barber, date, hour) VALUES (?, ?, ?) RETURNING *");

        $stmt->bindParam(
            1, $schedule->getService(),
            2, $schedule->getBarber(),
            3, $schedule->getDate(),
            4, $schedule->getHour(),
        );

        $stmt->execute();
        $rs = $stmt->fetchObject("ScheduleResponseDto");

        [$this->conn, $stmt] = null;

        return $rs;
    }

    public function update(Schedule $schedule, $id): ScheduleResponseDto {
        $stmt = $this->conn->prepare("UPDATE schedules SET service = ?, barber = ?, date = ?, hour = ? WHERE id = ? RETURNING *");
        
        $stmt->bindParam(
            1, $schedule->getService(),
            2, $schedule->getBarber(),
            3, $schedule->getDate(),
            4, $schedule->getHour(),
            5, $id,
        );

        $stmt->execute();
        $rs = $stmt->fetchObject("ScheduleResponseDto");

        [$this->conn, $stmt] = null;

        return $rs;
    }

    public function destroy(int $id): ScheduleResponseDto {
        $stmt = $this->conn->prepare("DELETE FROM schedules WHERE id = ? RETURNING *");

        $stmt->bindParam(1, $id);
        $stmt->execute();
        $rs = $stmt->fetchObject("ScheduleResponseDto");

        [$this->conn, $stmt] = null;

        return $rs;
    }
}
