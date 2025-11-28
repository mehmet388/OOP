<?php
session_start();

require_once "Game.php";
require_once "svg.php";

// Start spel als het er nog niet is
if (!isset($_SESSION['game'])) {
    $_SESSION['game'] = new Game();
}

$game = $_SESSION['game'];

// Bij worp
if (isset($_POST['throw'])) {
    if ($game->canThrow()) {
        $game->throwAllDice();
    }
}

// Resultaten ophalen
$results = $game->getResults();
$lastThrow = end($results) ?: [];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Dobbelspel</title>
</head>
<body style="font-family: Arial;">

<h1>Dobbelspel </h1>

<p><strong>Worp:</strong> <?= $game->getThrowCount(); ?>/3</p>

<form method="POST">
    <button type="submit" name="throw" <?= !$game->canThrow() ? "disabled" : "" ?>>
        Gooi dobbelstenen
    </button>
</form>

<hr>

<h2>Resultaten:</h2>

<?php foreach ($results as $index => $throw): ?>
    <h3>Worp <?= $index + 1 ?>:</h3>

    <?php
    // Feature: Highlight matching dice
    $counts = array_count_values($throw);
    ?>
    
    <?php foreach ($throw as $value): ?>
        <?php
        $color = $counts[$value] >= 2 ? "red" : "black";
        echo diceSVG($value, $color);
        ?>
    <?php endforeach; ?>

<?php endforeach; ?>

<hr>

<?php if ($lastThrow && $game->allEqual($lastThrow)): ?>
    <h2 style="color: green;"> JACKPOT! Alle dobbelstenen hetzelfde! +50 punten! </h2>
<?php endif; ?>

<form method="post">
    <button type="submit" name="reset">Restart spel</button>
</form>

<?php
if (isset($_POST['reset'])) {
    session_destroy();
    header("Location: index.php");
}
?>

</body>
</html>
