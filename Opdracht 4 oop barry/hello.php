<?php
// =======================
// Abstracte class Product
// =======================
abstract class Product {
    protected string $naam;
    protected float $inkoopprijs;
    protected float $btw;
    protected string $omschrijving;

    public function __construct(string $naam, float $inkoopprijs, float $btw, string $omschrijving) {
        $this->naam = $naam;
        $this->inkoopprijs = $inkoopprijs;
        $this->btw = $btw;
        $this->omschrijving = $omschrijving;
    }

    public function getNaam(): string { return $this->naam; }
    public function setNaam(string $naam): void { $this->naam = $naam; }

    public function getInkoopprijs(): float { return $this->inkoopprijs; }
    public function setInkoopprijs(float $inkoopprijs): void { $this->inkoopprijs = $inkoopprijs; }

    public function getBtw(): float { return $this->btw; }
    public function setBtw(float $btw): void { $this->btw = $btw; }

    public function getOmschrijving(): string { return $this->omschrijving; }
    public function setOmschrijving(string $omschrijving): void { $this->omschrijving = $omschrijving; }

    abstract public function getProductInfo(): string;

    public function getVerkoopprijs(float $winst): float {
        return ($this->inkoopprijs + $winst) * (1 + $this->btw / 100);
    }
}

// =======================
// Child Classes
// =======================
class Music extends Product {
    private string $artiest;
    private array $nummers;

    public function __construct(string $naam, float $inkoopprijs, float $btw, string $omschrijving, string $artiest, array $nummers) {
        parent::__construct($naam, $inkoopprijs, $btw, $omschrijving);
        $this->artiest = $artiest;
        $this->nummers = $nummers;
    }

    public function getProductInfo(): string {
        return "Artiest: {$this->artiest}, Nummers: " . implode(', ', $this->nummers);
    }
}

class Film extends Product {
    private string $kwaliteit;

    public function __construct(string $naam, float $inkoopprijs, float $btw, string $omschrijving, string $kwaliteit) {
        parent::__construct($naam, $inkoopprijs, $btw, $omschrijving);
        $this->kwaliteit = $kwaliteit;
    }

    public function getProductInfo(): string {
        return "Kwaliteit: {$this->kwaliteit}";
    }
}

class Game extends Product {
    private string $genre;
    private string $minHardware;

    public function __construct(string $naam, float $inkoopprijs, float $btw, string $omschrijving, string $genre, string $minHardware) {
        parent::__construct($naam, $inkoopprijs, $btw, $omschrijving);
        $this->genre = $genre;
        $this->minHardware = $minHardware;
    }

    public function getProductInfo(): string {
        return "Genre: {$this->genre}, Minimale hardware: {$this->minHardware}";
    }
}

// =======================
// ProductList Class
// =======================
class ProductList {
    private array $producten = [];

    public function addProduct(Product $product): void {
        $this->producten[] = $product;
    }

    public function showTable(float $winst): void {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Naam</th><th>Categorie</th><th>Verkoopprijs</th><th>Informatie</th></tr>";
        
        foreach ($this->producten as $product) {
            $categorie = strtolower((new ReflectionClass($product))->getShortName());
            $verkoopprijs = number_format($product->getVerkoopprijs($winst), 2);
            echo "<tr>";
            echo "<td>{$product->getNaam()}</td>";
            echo "<td>{$categorie}</td>";
            echo "<td>€{$verkoopprijs}</td>";
            echo "<td>{$product->getProductInfo()}</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
}

// =======================
// Voorbeeldgebruik
// =======================
$music1 = new Music("Best of 2020", 10, 21, "Top hits van 2020", "Artiest X", ["Song 1", "Song 2", "Song 3"]);
$film1 = new Film("Avengers", 15, 21, "Superhelden film", "BluRay");
$game1 = new Game("Cyberpunk 2077", 30, 21, "Open world RPG", "RPG", "16GB RAM, GTX 1070");

$lijst = new ProductList();
$lijst->addProduct($music1);
$lijst->addProduct($film1);
$lijst->addProduct($game1);

// Toon tabel met verkoopprijs + €5 winst
$lijst->showTable(5);
?>
