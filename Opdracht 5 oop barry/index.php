<?php

// Ziekenhuisbeheer - OOP PHP
// ABSTRACT PERSON
abstract class Person {
    private string $name;
    private int $age;

    public function __construct(string $name, int $age = 0) {
        $this->name = $name;
        $this->age = $age;
    }

    abstract public function getRole(): string;

    // Getters & Setters
    public function getName(): string {
        return $this->name;
    }
    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getAge(): int {
        return $this->age;
    }
    public function setAge(int $age): void {
        $this->age = $age;
    }
}

//  ABSTRACT STAFF 
abstract class Staff extends Person {
    protected float $baseSalary;
    protected int $id;

    public function __construct(string $name, int $age = 0, float $baseSalary = 0.0) {
        parent::__construct($name, $age);
        $this->baseSalary = $baseSalary;
        $this->id = spl_object_id($this);
    }

    abstract public function calculateSalary(array $appointments): float;

    public function getBaseSalary(): float {
        return $this->baseSalary;
    }
    public function setBaseSalary(float $salary): void {
        $this->baseSalary = $salary;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getRole(): string {
        return 'Staff';
    }
}

// DOCTOR CLASS 
class Doctor extends Staff {
    private float $hourlyRate;

    public function __construct(string $name, int $age = 0, float $hourlyRate = 80.0) {
        parent::__construct($name, $age, 0.0);
        $this->hourlyRate = $hourlyRate;
    }

    public function getRole(): string {
        return 'Doctor';
    }

    public function getHourlyRate(): float {
        return $this->hourlyRate;
    }

    public function setHourlyRate(float $rate): void {
        $this->hourlyRate = $rate;
    }

    public function calculateSalary(array $appointments): float {
        $total = 0;
        foreach ($appointments as $appt) {
            if ($appt->getDoctor() === $this) {
                $total += $appt->getDurationHours() * $this->hourlyRate;
            }
        }
        return $total;
    }
}

// NURSE CLASS
class Nurse extends Staff {
    private float $weeklySalary;
    private float $hourlyBonusRate;

    public function __construct(string $name, int $age = 0, float $weeklySalary = 800.0, float $hourlyBonusRate = 20.0) {
        parent::__construct($name, $age, $weeklySalary);
        $this->weeklySalary = $weeklySalary;
        $this->hourlyBonusRate = $hourlyBonusRate;
    }

    public function getRole(): string {
        return 'Nurse';
    }

    public function calculateSalary(array $appointments): float {
        $bonus = 0;
        foreach ($appointments as $appt) {
            if ($appt->getNurse() === $this) {
                $bonus += $appt->getDurationHours() * $this->hourlyBonusRate;
            }
        }
        return $this->weeklySalary + $bonus;
    }
}

//  PATIENT CLASS
class Patient extends Person {
    private float $balance;

    public function __construct(string $name, int $age = 0, float $balance = 0.0) {
        parent::__construct($name, $age);
        $this->balance = $balance;
    }

    public function getRole(): string {
        return 'Patient';
    }

    public function getBalance(): float {
        return $this->balance;
    }
    public function setBalance(float $balance): void {
        $this->balance = $balance;
    }

    public function pay(float $amount): void {
        $this->balance -= $amount;
    }

    public function makeAppointment(Staff $doctor, DateTime $start, DateTime $end, ?Nurse $nurse = null): Appointment {
        return new Appointment($this, $doctor, $start, $end, $nurse);
    }
}

//  APPOINTMENT CLASS 
class Appointment {
    private static array $appointments = [];

    private Patient $patient;
    private Doctor $doctor;
    private ?Nurse $nurse;
    private DateTime $startTime;
    private DateTime $endTime;

    public function __construct(Patient $patient, Doctor $doctor, DateTime $startTime, DateTime $endTime, ?Nurse $nurse = null) {
        $this->patient = $patient;
        $this->doctor = $doctor;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->nurse = $nurse;

        self::$appointments[] = $this;
    }

    public static function getAllAppointments(): array {
        return self::$appointments;
    }

    public function getDurationHours(): float {
        $interval = $this->startTime->diff($this->endTime);
        $hours = $interval->h + ($interval->i / 60);
        return $hours;
    }

    public function getPatient(): Patient {
        return $this->patient;
    }

    public function getDoctor(): Doctor {
        return $this->doctor;
    }

    public function getNurse(): ?Nurse {
        return $this->nurse;
    }

    public function showInfo(): void {
        echo "<b>Afspraak:</b> " . $this->patient->getName() . " met Dr. " . $this->doctor->getName();
        if ($this->nurse) echo " en verpleegkundige " . $this->nurse->getName();
        echo " (" . $this->getDurationHours() . " uur)<br>";
    }
}



// Maak enkele objecten aan
$doctor = new Doctor("Dr. Janssen", 45, 100);
$nurse = new Nurse("Sanne", 30, 800, 25);
$patient1 = new Patient("Piet", 35, 500);
$patient2 = new Patient("Anna", 28, 700);

// Maak afspraken
$appt1 = $patient1->makeAppointment($doctor, new DateTime("2025-10-16 09:00"), new DateTime("2025-10-16 10:30"), $nurse);
$appt2 = $patient2->makeAppointment($doctor, new DateTime("2025-10-16 11:00"), new DateTime("2025-10-16 12:00"));

// Toon afspraken
echo "<h2>🩺 Afspraken</h2>";
foreach (Appointment::getAllAppointments() as $appt) {
    $appt->showInfo();
}

// Bereken salarissen
$appointments = Appointment::getAllAppointments();

echo "<hr><h2>💰 Salarissen</h2>";
echo "Dokter " . $doctor->getName() . ": €" . $doctor->calculateSalary($appointments) . "<br>";
echo "Verpleegkundige " . $nurse->getName() . ": €" . $nurse->calculateSalary($appointments) . "<br>";

?>
