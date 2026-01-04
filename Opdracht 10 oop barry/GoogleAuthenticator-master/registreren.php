<?php
session_start();

// Database gegevens
$dsn = "mysql:host=localhost;dbname=login2fa;charset=utf8mb4";
$user = "root";
$pass = "";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];

// Database verbinding
$pdo = new PDO($dsn, $user, $pass, $options);

// Google Authenticator includen
require_once 'GoogleAuthenticator.php';

use PHPGangsta\GoogleAuthenticator;

$ga = new GoogleAuthenticator();
$qrCodeUrl = null;
$secret = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Wachtwoord hashen
    $password = password_hash($password, PASSWORD_DEFAULT);

    // 2FA secret genereren
    $secret = $ga->createSecret();

    // Gebruiker opslaan
    $stmt = $pdo->prepare(
        "INSERT INTO users (username, password, 2fa_secret) VALUES (?, ?, ?)"
    );
    $stmt->execute([$username, $password, $secret]);

    // QR-code genereren
    $qrCodeUrl = $ga->getQRCodeGoogleUrl('TCRHELDEN', $secret);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
</head>
<body>

<h1>Register</h1>

<form method="post">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Registreren</button>
</form>

<?php if ($qrCodeUrl): ?>
    <h3>Registratie succesvol! Scan deze QR code met Google Authenticator:</h3>

    <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code"><br>

    <p>Sla de geheime sleutel op: <strong><?php echo $secret; ?></strong></p>
<?php endif; ?>

<br>
<a href="inloggen.php">Login</a>

</body>
</html>
