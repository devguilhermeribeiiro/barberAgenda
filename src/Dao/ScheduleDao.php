<?php

namespace BarberAgenda\Dao;

use BarberAgenda\Config\Database;
use BarberAgenda\Dto\ScheduleResponseDto;
use BarberAgenda\Entity\Schedule;
use PDO;

class ScheduleDao
{
    private PDO $conn = Database::getConnection();

    public function findAll(): array
    {
        $rs = $this->conn->query("SELECT * FROM schedules");
        $schedules = $rs->fetch(PDO::FETCH_ASSOC);
        return $schedules;   
    }

    public function findById(int $id): ScheduleResponseDto {
        $stmt = $this->conn->prepare("SELECT * FROM schedules WHERE id = ?");
        $stmt->bindParam(1, $id);
        $rs = $stmt->execute();

        return new ScheduleResponseDto;
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

        return $rs;
    }

    public function update(Schedule $schedule): ScheduleResponseDto {
        $stmt = $this->conn->prepare("UPDATE schedules SET service = ?, barber = ?, date = ?, hour = ? WHERE id = ? RETURNING *");
        
        $stmt->bindParam(
            1, $schedule->getService(),
            2, $schedule->getBarber(),
            3, $schedule->getDate(),
            4, $schedule->getHour(),
        );

        $stmt->execute();
        $rs = $stmt->fetchObject("ScheduleResponseDto");

        return $rs;
    }

    public function destroy(int $id): ScheduleResponseDto {
        $stmt = $this->conn->prepare("DELETE FROM schedules WHERE id = ? RETURNING *");

        $stmt->bindParam(1, $id);
        $stmt->execute();
        $rs = $stmt->fetchObject("ScheduleResponseDto");

        return $rs;
    }
}
