<?php
session_start();

/* --------------------------------------------
   Functies voor het spel
----------------------------------------------*/

// Logica per dobbelsteenworp
function getWak($value) {
    return in_array($value, [1,3,5]) ? 1 : 0;
}
function getIJsberen($value) {
    return match($value) {
        1 => 0,
        3 => 2,
        5 => 4,
        default => 0
    };
}
function getPingwins($value) {
    if (!in_array($value, [1,3,5])) return 0;
    return 7 - $value; // zuidpool
}

// Nieuwe worp
if (isset($_POST['aantal'])) {
    $aantal = intval($_POST['aantal']);
    $_SESSION['dobbelstenen'] = [];

    for ($i = 0; $i < $aantal; $i++) {
        $_SESSION['dobbelstenen'][] = rand(1,6);
    }

    $_SESSION['raden'] = 0;
    $_SESSION['oplossing_getoond'] = false;

    $_SESSION['games'] = ($_SESSION['games'] ?? 0) + 1;
}

// Raden
$feedback = "";
$hint = "";

if (isset($_POST['raad_submit'])) {
    if (!$_SESSION['oplossing_getoond']) {
        $_SESSION['raden']++;

        // totale waarden berekenen
        $wakken = 0; $ijsberen = 0; $pingwins = 0;
        foreach ($_SESSION['dobbelstenen'] as $waarde) {
            $wakken += getWak($waarde);
            $ijsberen += getIJsberen($waarde);
            if (getWak($waarde) === 1) {
                $pingwins += getPingwins($waarde);
            }
        }

        // controle
        if ($_POST['wak'] == $wakken && $_POST['beer'] == $ijsberen && $_POST['ping'] == $pingwins) {
            $feedback = "<p style='color:green;font-weight:bold'>Correct!</p>";
            $_SESSION['goed'] = ($_SESSION['goed'] ?? 0) + 1;

        } else {
            $feedback = "<p style='color:red;font-weight:bold'>Fout.. probeer opnieuw!</p>";
            $_SESSION['fout'] = ($_SESSION['fout'] ?? 0) + 1;

            // hints
            if ($_SESSION['raden'] >= 3) {
                $hints = [
                    "IJsberen zitten alleen om een wak.",
                    "Pingwins zitten op de zuidpool bij dobbelstenen met wak.",
                    "Wak = 1,3,5. Geen wak = 2,4,6."
                ];
                $hint = "<p style='color:blue'><b>Hint:</b> " . $hints[array_rand($hints)] . "</p>";
            }
        }
    }
}

// Oplossing tonen
$oplossing = "";
if (isset($_POST['oplossing'])) {
    $_SESSION['oplossing_getoond'] = true;

    $wakken = 0; $ijsberen = 0; $pingwins = 0;

    foreach ($_SESSION['dobbelstenen'] as $waarde) {
        $wakken += getWak($waarde);
        $ijsberen += getIJsberen($waarde);
        if (getWak($waarde) === 1) {
            $pingwins += 7 - $waarde;
        }
    }

    $oplossing = "
        <p><b>Oplossing:</b></p>
        <ul>
            <li>Wakken: $wakken</li>
            <li>IJsberen: $ijsberen</li>
            <li>Pingwins: $pingwins</li>
        </ul>
    ";
}

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Wakken en IJsberen</title>
</head>
<body>

<h2>Wakken en de IJsberen</h2>

<!-- keuze aantal dobbelstenen -->
<form method="post">
    <label>Kies aantal dobbelstenen (3-8):</label>
    <select name="aantal">
        <?php for ($i = 3; $i <= 8; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
        <?php endfor; ?>
    </select>
    <button type="submit">Gooi</button>
</form>

<hr>

<?php if (!empty($_SESSION['dobbelstenen'])): ?>

    <h3>Dobbelstenen:</h3>
    <p>
        <?php foreach ($_SESSION['dobbelstenen'] as $d): ?>
            🎲 <?= $d ?> &nbsp;
        <?php endforeach; ?>
    </p>

    <!-- raden -->
    <?php if (!$_SESSION['oplossing_getoond']): ?>
        <h3>Raad het aantal</h3>

        <form method="post">
            <label>Wakken:</label>
            <input type="number" name="wak" required>
            <br>

            <label>IJsberen:</label>
            <input type="number" name="beer" required>
            <br>

            <label>Pingwins:</label>
            <input type="number" name="ping" required>
            <br><br>

            <button name="raad_submit" type="submit">Raden</button>
        </form>

        <form method="post" style="margin-top:10px;">
            <button name="oplossing">Toon oplossing</button>
        </form>
    <?php endif; ?>

    <?= $feedback ?>
    <?= $hint ?>
    <?= $oplossing ?>

<?php endif; ?>

<hr>

<h3>Statistieken</h3>
<ul>
    <li>Games gespeeld: <?= $_SESSION['games'] ?? 0 ?></li>
    <li>Totaal goed: <?= $_SESSION['goed'] ?? 0 ?></li>
    <li>Totaal fout: <?= $_SESSION['fout'] ?? 0 ?></li>
    <li>Fouten in deze game: <?= $_SESSION['raden'] ?? 0 ?></li>
</ul>

</body>
</html>
