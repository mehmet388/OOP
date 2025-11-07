<?php
abstract class Persoon {
    protected string $naam;
    protected string $klas;

    public function __construct(string $naam, string $klas) {
        $this->naam = $naam;
        $this->klas = $klas;
    }

    public function getNaam(): string {
        return $this->naam;
    }

    public function getKlas(): string {
        return $this->klas;
    }
}

class Leerling extends Persoon {
    private bool $heeftBetaald;

    public function __construct(string $naam, string $klas, bool $heeftBetaald = false) {
        parent::__construct($naam, $klas);
        $this->heeftBetaald = $heeftBetaald;
    }

    public function heeftBetaald(): bool {
        return $this->heeftBetaald;
    }

    public function setBetaald(bool $betaald): void {
        $this->heeftBetaald = $betaald;
    }
}

class Docent extends Persoon {
    // Docent heeft geen extra properties
}

class SchooltripList {
    private array $leerlingen = [];
    private array $docenten = [];

    public function addLeerling(Leerling $leerling): void {
        $this->leerlingen[] = $leerling;
    }

    public function addDocent(Docent $docent): void {
        $this->docenten[] = $docent;
    }

    public function getAantalBetaaldeLeerlingen(): int {
        return count(array_filter($this->leerlingen, fn($l) => $l->heeftBetaald()));
    }

    public function getDocentenDieMeeMogen(): array {
        $maxDocenten = floor($this->getAantalBetaaldeLeerlingen() / 5);
        return array_slice($this->docenten, 0, $maxDocenten);
    }

    public function toonOverzicht(): void {
        echo "<h2>Overzicht Schooluitje</h2>";

        // groepeer per klas
        $klassen = [];
        foreach ($this->leerlingen as $l) {
            $klassen[$l->getKlas()][] = $l;
        }

        foreach ($klassen as $klasNaam => $groep) {
            $totaal = count($groep);
            $betaald = count(array_filter($groep, fn($l) => $l->heeftBetaald()));
            $percentage = round(($betaald / $totaal) * 100, 1);

            echo "<h3>Klas: $klasNaam</h3>";
            echo "Aantal leerlingen: $totaal, Betaald: $betaald ($percentage%)<br>";

            foreach ($groep as $l) {
                $status = $l->heeftBetaald() ? "✅ Betaald" : "❌ Niet betaald";
                echo "- {$l->getNaam()} ($status)<br>";
            }
        }

        echo "<h3>Docenten die mee mogen:</h3>";
        foreach ($this->getDocentenDieMeeMogen() as $d) {
            echo "- {$d->getNaam()} ({$d->getKlas()})<br>";
        }

        echo "<p><strong>Totaal betaalde leerlingen:</strong> " . $this->getAantalBetaaldeLeerlingen() . "</p>";
    }
}

// --- Testdata ---
$trip = new SchooltripList();

$trip->addLeerling(new Leerling("Sam", "SD1A", true));
$trip->addLeerling(new Leerling("Fatima", "SD1A", false));
$trip->addLeerling(new Leerling("Lars", "SD1A", true));
$trip->addLeerling(new Leerling("Noa", "SD1B", true));
$trip->addLeerling(new Leerling("Iris", "SD1B", true));
$trip->addLeerling(new Leerling("Tom", "SD1B", true));

$trip->addDocent(new Docent("Mevrouw de Vries", "SD1A"));
$trip->addDocent(new Docent("Meneer Bakker", "SD1B"));

$trip->toonOverzicht();
