@here <?php
class Huis {
  
    private int $aantalVerdiepingen;
    private int $aantalKamers;
    private float $breedte;
    private float $hoogte;
    private float $diepte;
    private float $prijsPerM3 = 1500;


    public function __construct(int $aantalVerdiepingen, int $aantalKamers, float $breedte, float $hoogte, float $diepte) {
        $this->aantalVerdiepingen = $aantalVerdiepingen;
        $this->aantalKamers = $aantalKamers;
        $this->breedte = $breedte;
        $this->hoogte = $hoogte;
        $this->diepte = $diepte;
    }

   
    public function berekenVolume(): float {
        return $this->breedte * $this->hoogte * $this->diepte;
    }

    
    public function berekenPrijs(): float {
        return $this->berekenVolume() * $this->prijsPerM3;
    }

    
    public function toonDetails(): void {
        echo "🏠 Huisdetails:<br>";
        echo "- Aantal verdiepingen: {$this->aantalVerdiepingen}<br>";
        echo "- Aantal kamers: {$this->aantalKamers}<br>";
        echo "- Afmetingen: {$this->breedte}m × {$this->hoogte}m × {$this->diepte}m<br>";
        echo "- Volume: " . $this->berekenVolume() . " m³<br>";
        echo "- Prijs: €" . number_format($this->berekenPrijs(), 2, ',', '.') . "<br><br>";
    }
}


$huis1 = new Huis(2, 5, 8.0, 6.0, 10.0);
$huis2 = new Huis(3, 8, 10.0, 9.0, 12.0);
$huis3 = new Huis(1, 3, 6.5, 5.0, 8.0);


$huis1->toonDetails();
$huis2->toonDetails();
$huis3->toonDetails();
?>