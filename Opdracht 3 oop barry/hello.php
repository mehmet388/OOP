<?php
// Namespace voor de figuren - moet bovenaan staan
namespace FigurenSpel;

// Abstract parent class Figuur
abstract class Figuur
{
    // Private properties met visibility en datatype
    private string $kleur;
    private int $x;
    private int $y;
    
    // Constructor
    public function __construct(string $kleur, int $x, int $y)
    {
        $this->kleur = $kleur;
        $this->x = $x;
        $this->y = $y;
    }
    
    // Getters
    public function getKleur(): string
    {
        return $this->kleur;
    }
    
    public function getX(): int
    {
        return $this->x;
    }
    
    public function getY(): int
    {
        return $this->y;
    }
    
    // Setters
    public function setKleur(string $kleur): void
    {
        $this->kleur = $kleur;
    }
    
    public function setX(int $x): void
    {
        $this->x = $x;
    }
    
    public function setY(int $y): void
    {
        $this->y = $y;
    }
    
    // Abstract draw methode
    abstract public function draw(): string;
}

// Child class Vierkant
class Vierkant extends Figuur
{
    private int $zijde;
    
    public function __construct(string $kleur, int $x, int $y, int $zijde)
    {
        parent::__construct($kleur, $x, $y);
        $this->zijde = $zijde;
    }
    
    public function getZijde(): int
    {
        return $this->zijde;
    }
    
    public function setZijde(int $zijde): void
    {
        $this->zijde = $zijde;
    }
    
    public function draw(): string
    {
        return '<svg width="120" height="120">
            <rect x="' . $this->getX() . '" y="' . $this->getY() . '" 
                  width="' . $this->zijde . '" height="' . $this->zijde . '" 
                  fill="' . $this->getKleur() . '" stroke="black" stroke-width="2"/>
        </svg>';
    }
}

// Child class Cirkel
class Cirkel extends Figuur
{
    private int $straal;
    
    public function __construct(string $kleur, int $x, int $y, int $straal)
    {
        parent::__construct($kleur, $x, $y);
        $this->straal = $straal;
    }
    
    public function getStraal(): int
    {
        return $this->straal;
    }
    
    public function setStraal(int $straal): void
    {
        $this->straal = $straal;
    }
    
    public function draw(): string
    {
        $centerX = $this->getX() + $this->straal;
        $centerY = $this->getY() + $this->straal;
        
        return '<svg width="120" height="120">
            <circle cx="' . $centerX . '" cy="' . $centerY . '" 
                    r="' . $this->straal . '" 
                    fill="' . $this->getKleur() . '" stroke="black" stroke-width="2"/>
        </svg>';
    }
}

// Child class Rechthoek
class Rechthoek extends Figuur
{
    private int $breedte;
    private int $hoogte;
    
    public function __construct(string $kleur, int $x, int $y, int $breedte, int $hoogte)
    {
        parent::__construct($kleur, $x, $y);
        $this->breedte = $breedte;
        $this->hoogte = $hoogte;
    }
    
    public function getBreedte(): int
    {
        return $this->breedte;
    }
    
    public function getHoogte(): int
    {
        return $this->hoogte;
    }
    
    public function setBreedte(int $breedte): void
    {
        $this->breedte = $breedte;
    }
    
    public function setHoogte(int $hoogte): void
    {
        $this->hoogte = $hoogte;
    }
    
    public function draw(): string
    {
        return '<svg width="120" height="120">
            <rect x="' . $this->getX() . '" y="' . $this->getY() . '" 
                  width="' . $this->breedte . '" height="' . $this->hoogte . '" 
                  fill="' . $this->getKleur() . '" stroke="black" stroke-width="2"/>
        </svg>';
    }
}

// Child class Driehoek
class Driehoek extends Figuur
{
    private int $basis;
    private int $hoogte;
    
    public function __construct(string $kleur, int $x, int $y, int $basis, int $hoogte)
    {
        parent::__construct($kleur, $x, $y);
        $this->basis = $basis;
        $this->hoogte = $hoogte;
    }
    
    public function getBasis(): int
    {
        return $this->basis;
    }
    
    public function getHoogte(): int
    {
        return $this->hoogte;
    }
    
    public function setBasis(int $basis): void
    {
        $this->basis = $basis;
    }
    
    public function setHoogte(int $hoogte): void
    {
        $this->hoogte = $hoogte;
    }
    
    public function draw(): string
    {
        $x1 = $this->getX() + ($this->basis / 2);
        $y1 = $this->getY();
        $x2 = $this->getX();
        $y2 = $this->getY() + $this->hoogte;
        $x3 = $this->getX() + $this->basis;
        $y3 = $this->getY() + $this->hoogte;
        
        $points = "$x1,$y1 $x2,$y2 $x3,$y3";
        
        return '<svg width="120" height="120">
            <polygon points="' . $points . '" 
                     fill="' . $this->getKleur() . '" stroke="black" stroke-width="2"/>
        </svg>';
    }
}

// Objecten maken met lowerCamelCase namen
$roodVierkant = new Vierkant("red", 10, 10, 80);
$groeneCircel = new Cirkel("green", 10, 10, 40);
$blauwRechthoek = new Rechthoek("blue", 10, 20, 100, 60);
$geleDriehoek = new Driehoek("yellow", 10, 10, 80, 70);

$oranjeVierkant = new Vierkant("orange", 10, 10, 80);
$paarseCirkel = new Cirkel("purple", 10, 10, 40);
$groeneRechthoek = new Rechthoek("green", 10, 20, 100, 60);
$rodeDriehoek = new Driehoek("red", 10, 10, 80, 70);

// Array met alle figuren
$figuren = [
    $roodVierkant,
    $groeneCircel,
    $blauwRechthoek,
    $geleDriehoek,
    $oranjeVierkant,
    $paarseCirkel,
    $groeneRechthoek,
    $rodeDriehoek
];
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OOP Opdracht 3 - Drie op een rij</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .shapes-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
        .shape-container {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        h2 {
            color: #666;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Drie op een rij - Figuren</h1>
        
        <h2>Alle Figuren:</h2>
        <div class="shapes-grid">
            <?php foreach ($figuren as $index => $figuur): ?>
                <div class="shape-container">
                    <h3><?= get_class($figuur) ?></h3>
                    <p>Kleur: <?= $figuur->getKleur() ?></p>
                    <p>Positie: (<?= $figuur->getX() ?>, <?= $figuur->getY() ?>)</p>
                    
                    <?php if ($figuur instanceof Vierkant): ?>
                        <p>Zijde: <?= $figuur->getZijde() ?>px</p>
                    <?php elseif ($figuur instanceof Cirkel): ?>
                        <p>Straal: <?= $figuur->getStraal() ?>px</p>
                    <?php elseif ($figuur instanceof Rechthoek): ?>
                        <p>Breedte: <?= $figuur->getBreedte() ?>px</p>
                        <p>Hoogte: <?= $figuur->getHoogte() ?>px</p>
                    <?php elseif ($figuur instanceof Driehoek): ?>
                        <p>Basis: <?= $figuur->getBasis() ?>px</p>
                        <p>Hoogte: <?= $figuur->getHoogte() ?>px</p>
                    <?php endif; ?>
                    
                    <?= $figuur->draw() ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <h2>Eigenschappen via Getters:</h2>
        <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin-top: 20px;">
            <?php foreach ($figuren as $index => $figuur): ?>
                <p><strong>Figuur <?= $index + 1 ?>:</strong> 
                   <?= get_class($figuur) ?> - 
                   Kleur: <?= $figuur->getKleur() ?> - 
                   Positie: (<?= $figuur->getX() ?>, <?= $figuur->getY() ?>)
                   
                   <?php if ($figuur instanceof Vierkant): ?>
                       - Zijde: <?= $figuur->getZijde() ?>px
                   <?php elseif ($figuur instanceof Cirkel): ?>
                       - Straal: <?= $figuur->getStraal() ?>px
                   <?php elseif ($figuur instanceof Rechthoek): ?>
                       - Afmetingen: <?= $figuur->getBreedte() ?>x<?= $figuur->getHoogte() ?>px
                   <?php elseif ($figuur instanceof Driehoek): ?>
                       - Basis: <?= $figuur->getBasis() ?>px, Hoogte: <?= $figuur->getHoogte() ?>px
                   <?php endif; ?>
                </p>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>