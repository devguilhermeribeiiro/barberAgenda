<?php

namespace BarberAgenda\Dao;

use BarberAgenda\Dto\ScheduleResponseDto;
use BarberAgenda\Entity\Schedule;
use BarberAgenda\Repository\ScheduleRepository;
use DateTime;
use PDO;
use stdClass;

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
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        [$this->conn, $stmt] = null;

        return $rs;
    }

    public function findById(int $id): stdClass {
        $stmt = $this->conn->prepare("SELECT * FROM schedules WHERE id = ?");
        $stmt->bindValue(1, $id);
        $stmt->execute();

        $rs = $stmt->fetch(PDO::FETCH_OBJ);

        [$this->conn, $stmt] = null;

        if (!$rs) {
            echo json_encode(["error" => "schedule not found"]);
            die();
        }

        return $rs;
    }

    public function save(Schedule $schedule): ScheduleResponseDto {
        $stmt = $this->conn->prepare("INSERT INTO schedules (service, barber, date, hour) VALUES (?, ?, ?, ?) RETURNING *");

        $service = $schedule->getService();
        $barber = $schedule->getBarber();
        $date = DateTime::createFromFormat("d/m/Y", $schedule->getDate())->format("Y/m/d");
        $hour = DateTime::createFromFormat("H:i", $schedule->getHour())->format("H:i");

        $stmt->bindValue(1, $service);
        $stmt->bindValue(2, $barber);
        $stmt->bindValue(3, $date);
        $stmt->bindValue(4, $hour);

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, ScheduleResponseDto::class);
        $rs = $stmt->fetch();

        [$this->conn, $stmt] = null;

        return $rs;
    }

    public function update(Schedule $schedule, int $id): stdClass {
        $stmt = $this->conn->prepare("UPDATE schedules SET service = ?, barber = ?, date = ?, hour = ? WHERE id = ? RETURNING *");
        
        $service = $schedule->getService();
        $barber = $schedule->getBarber();
        $date = DateTime::createFromFormat("d/m/Y", $schedule->getDate())->format("Y/m/d");
        $hour = DateTime::createFromFormat("H:i", $schedule->getHour())->format("H:i");

        $stmt->bindValue(1, $service);
        $stmt->bindValue(2, $barber);
        $stmt->bindValue(3, $date);
        $stmt->bindValue(4, $hour);
        $stmt->bindValue(5, $id, PDO::PARAM_INT);
        
        $stmt->execute();
        $rs = $stmt->fetch(PDO::FETCH_OBJ);

        [$this->conn, $stmt] = null;

        var_dump($rs);
        return $rs;
    }

    public function destroy(int $id) {
        $stmt = $this->conn->prepare("DELETE FROM schedules WHERE id = ?");

        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        
        $stmt->execute();
        $rs = $stmt->fetch();

        [$this->conn, $stmt] = null;

        return $rs;
    }
}
