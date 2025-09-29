<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

class Room {
    private string $name;
    private float $length;
    private float $width;
    private float $height;

    public function __construct(string $name, float $length, float $width, float $height) {
        $this->name   = $name;
        $this->length = $length;
        $this->width  = $width;
        $this->height = $height;
    }

    public function calculateVolume(): float {
        return $this->length * $this->width * $this->height;
    }

    public function showDetails(): string {
        return sprintf(
            "%s — %.2fm × %.2fm × %.2fm → %.2f m³",
            $this->name,
            $this->length,
            $this->width,
            $this->height,
            $this->calculateVolume()
        );
    }
}

class House {
    private int $floors;
    /** @var Room[] */
    private array $rooms = [];
    private const PRICE_PER_M3 = 1500.0;

    public function __construct(int $floors) {
        $this->floors = $floors;
    }

    public function addRoom(Room $room): void {
        $this->rooms[] = $room;
    }

    public function getRooms(): array {
        return $this->rooms;
    }

    public function calculateTotalVolume(): float {
        $total = 0.0;
        foreach ($this->rooms as $room) {
            $total += $room->calculateVolume();
        }
        return $total;
    }

    public function calculatePrice(): float {
        return $this->calculateTotalVolume() * self::PRICE_PER_M3;
    }

    public function showDetails(): void {
        echo "<div style='border:1px solid #ccc;padding:10px;margin:10px 0;border-radius:10px;'>";
        echo "<strong>🏠 House details</strong><br>";
        echo "Floors: {$this->floors}<br>";
        echo "Number of rooms: " . count($this->rooms) . "<br><br>";

        if (count($this->rooms) > 0) {
            echo "<em>Rooms:</em><br>";
            foreach ($this->rooms as $i => $room) {
                echo ($i + 1) . ". " . $room->showDetails() . "<br>";
            }
        } else {
            echo "<em>No rooms yet</em><br>";
        }

        echo "<br>Total volume: " . number_format($this->calculateTotalVolume(), 2, ',', '.') . " m³<br>";
        echo "Price: €" . number_format($this->calculatePrice(), 2, ',', '.') . "<br>";
        echo "</div>";
    }
}

/* ----------------------------------
   Voorbeeld: meerdere huizen in array
---------------------------------- */

$houses = [];

// Huis 1 met kamers
$house1 = new House(2);
$house1->addRoom(new Room('Living Room', 8.0, 5.0, 2.8));
$house1->addRoom(new Room('Bedroom', 4.5, 3.5, 2.7));
$houses[] = $house1;

// Huis 2 met andere kamers
$house2 = new House(1);
$house2->addRoom(new Room('Studio', 6.0, 4.0, 2.6));
$house2->addRoom(new Room('Bathroom', 2.0, 1.6, 2.6));
$houses[] = $house2;

// Huis 3 nog leeg (later kamers via formulier toevoegen)
$house3 = new House(3);
$houses[] = $house3;

/* ----------------------------------
   Formulier om kamer toe te voegen
---------------------------------- */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $houseIndex = (int)$_POST['houseIndex']; // welk huis
    $name = $_POST['name'] ?? '';
    $length = (float)$_POST['length'];
    $width  = (float)$_POST['width'];
    $height = (float)$_POST['height'];

    if (isset($houses[$houseIndex])) {
        $houses[$houseIndex]->addRoom(new Room($name, $length, $width, $height));
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Huizen overzicht</title>
</head>
<body>
    <h1>🏡 Huizen overzicht</h1>

    <?php
    // Loop door alle huizen en toon details
    foreach ($houses as $index => $house) {
        echo "<h2>Huis " . ($index + 1) . "</h2>";
        $house->showDetails();
    }
    ?>

    <h2>➕ Kamer toevoegen aan huis</h2>
    <form method="POST">
        <label>Huis nummer:
            <select name="houseIndex">
                <?php foreach ($houses as $index => $h) {
                    echo "<option value='{$index}'>Huis " . ($index + 1) . "</option>";
                } ?>
            </select>
        </label><br><br>

        <label>Naam kamer: <input type="text" name="name" required></label><br><br>
        <label>Lengte (m): <input type="number" step="0.1" name="length" required></label><br><br>
        <label>Breedte (m): <input type="number" step="0.1" name="width" required></label><br><br>
        <label>Hoogte (m): <input type="number" step="0.1" name="height" required></label><br><br>

        <button type="submit">Toevoegen</button>
    </form>
</body>
</html>
