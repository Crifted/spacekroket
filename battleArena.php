// battlefield.php: De arena waar de gevechten plaatsvinden
// - Toont de live status van CheeseShip en CakeShip
// - Laat spelers aanvallen uitvoeren via knoppen (schieten, beams)
// - Bevat knoppen voor het opslaan, laden, en resetten van het spel
// - Verwerkt acties via index.php (sessiebeheer en game-logica)


<?php
// Zorg ervoor dat de bestanden Spacekaas.php en Spacecake.php worden ingeladen
// zodat we de klassen Spacekaas en Spacecake kunnen gebruiken in dit script.
include_once 'CheeseShip.php';
include_once 'CakeShip.php';


// Start een sessie zodat we de status van de spelers (schepen) kunnen opslaan en ophalen.
session_start();

// Definieer de bestandsnamen voor het opslaan van de game status.
// Deze bestanden worden gebruikt om de voortgang van het spel te bewaren of te laden.
$saveFilePathKaas = 'spacekaas_save.txt';
$saveFilePathCake = 'spacecake_save.txt';

// Controleer of de schepen (Spacekaas en Spacecake) al in de sessie staan.
// Als ze niet bestaan, maken we nieuwe objecten aan voor beide schepen.
if (!isset($_SESSION['spacekaas']) || !isset($_SESSION['spacecake'])) {
    $_SESSION['spacekaas'] = new Spacekaas(true, 100, 100); // Initialiseer Spacekaas.
    $_SESSION['spacecake'] = new Spacecake(true, 100, 100); // Initialiseer Spacecake.
}

// Haal de schepen op uit de sessie zodat we hun status kunnen gebruiken in de game.
$spacekaas = $_SESSION['spacekaas'];
$spacecake = $_SESSION['spacecake'];

// Controleer of de gebruiker een actie heeft gekozen (bijvoorbeeld schieten of opslaan).
if (isset($_POST['action'])) {
    // Verwerk de actie op basis van wat de gebruiker heeft geselecteerd.
    if ($_POST['action'] == 'spacekaas_shoot') {
        // Spacekaas valt Spacecake aan met een KaasBullet.
        $damage = $spacekaas->shootKaasBullet(); // Bereken de schade.
        $spacecake->hit($damage); // Breng de schade toe aan Spacecake.

    } elseif ($_POST['action'] == 'spacecake_shoot') {
        // Spacecake valt Spacekaas aan met een CakeBullet.
        $damage = $spacecake->shootCakeBullet(); // Bereken de schade.
        $spacekaas->hit($damage); // Breng de schade toe aan Spacekaas.

    } elseif ($_POST['action'] == 'spacekaas_beam') {
        // Spacekaas gebruikt de krachtige KaasBeam.
        $damage = $spacekaas->KaasBeam(); // Bereken de schade.
        $spacecake->hit($damage); // Breng de schade toe aan Spacecake.

    } elseif ($_POST['action'] == 'spacecake_beam') {
        // Spacecake gebruikt de krachtige CakeBeam.
        $damage = $spacecake->CakeBeam(); // Bereken de schade.
        $spacekaas->hit($damage); // Breng de schade toe aan Spacekaas.

    } elseif ($_POST['action'] == 'save') {
        // Sla de status van beide schepen op in bestanden.
        $spacekaas->save($saveFilePathKaas); // Sla de status van Spacekaas op.
        $spacecake->save($saveFilePathCake); // Sla de status van Spacecake op.
        echo "Voortgang van het spel opgeslagen.<br>"; // Bevestiging voor de gebruiker.

    } elseif ($_POST['action'] == 'load') {
        // Laad de status van beide schepen uit de bestanden.
        if (file_exists($saveFilePathKaas) && file_exists($saveFilePathCake)) {
            $spacekaas->load($saveFilePathKaas); // Laad de status van Spacekaas.
            $spacecake->load($saveFilePathCake); // Laad de status van Spacecake.
            echo "Voortgang van het spel geladen.<br>"; // Bevestiging voor de gebruiker.
        } else {
            echo "Geen opgeslagen voortgang gevonden!<br>"; // Laat de gebruiker weten dat er geen opgeslagen gegevens zijn.
        }

    } elseif ($_POST['action'] == 'reset') {
        // Reset de game door de sessie te vernietigen en de pagina opnieuw te laden.
        session_destroy(); // Verwijder alle sessiegegevens.
        header("Location: battlefield.php"); // Herlaad de pagina.
        exit(); // Stop het script om fouten te voorkomen.
    }
}

// Update de sessie met de nieuwe status van Spacekaas en Spacecake.
// Hierdoor worden de wijzigingen (zoals minder HP of ammo) opgeslagen.
$_SESSION['spacekaas'] = $spacekaas;
$_SESSION['spacecake'] = $spacecake;
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Spacekaas vs Spacecake Battle</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #141e30, #243b55);
            font-family: 'Arial', sans-serif;
            color: #fff;
            text-align: center;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h2 {
            font-size: 36px;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }

        p {
            font-size: 20px;
            margin: 10px 0;
        }

        hr {
            width: 80%;
            border: 1px solid #fff;
            margin: 20px auto;
        }

        form {
            margin: 20px 0;
        }

        button {
            background-color: #1f4068;
            border: none;
            border-radius: 5px;
            color: white;
            padding: 12px 20px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 14px;
            margin: 10px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #1b1b2f;
            transform: scale(1.05);
        }

        button:disabled {
            background-color: #555;
            cursor: not-allowed;
        }

        h3 {
            font-size: 24px;
            color: #f50057;
            margin-top: 20px;
        }

        p.defeated {
            font-size: 18px;
            color: #ff1744;
        }
    </style>
</head>

<body>
    <h2>Spacekaas vs Spacecake Battle</h2>
    
    <!-- Display the status of both ships -->
    <p style="font-family: Cambria; font-size: 20px;">
        <strong>Spacekaas Status:</strong><br>
        Ammo: <?= $spacekaas->ammo ?><br>
        Hit Points: <?= $spacekaas->hitPoints ?><br>
        Kaas Bullets: <?= $spacekaas->kaasBullet ?><br>
        Kaas Beams: <?= $spacekaas->kaasBeam ?><br>
        Alive: <?= $spacekaas->isAlive ? 'Yes' : 'No' ?><br>
        <hr>

        <strong>Spacecake Status:</strong><br>
        Ammo: <?= $spacecake->ammo ?><br>
        Hit Points: <?= $spacecake->hitPoints ?><br>
        Cake Bullets: <?= $spacecake->cakeBullet ?><br>
        Cake Beams: <?= $spacecake->cakeBeam ?><br>
        Alive: <?= $spacecake->isAlive ? 'Yes' : 'No' ?><br>
    </p>

    <!-- Form for the battle actions -->
    <form method="post" action="">
        <button type="submit" name="action" value="spacekaas_shoot" <?= !$spacekaas->isAlive || !$spacecake->isAlive ? 'disabled' : '' ?>>Spacekaas Shoots Spacecake</button>
        <button type="submit" name="action" value="spacecake_shoot" <?= !$spacecake->isAlive || !$spacekaas->isAlive ? 'disabled' : '' ?>>Spacecake Shoots Spacekaas</button>
        <br>
        <button type="submit" name="action" value="spacekaas_beam" <?= !$spacekaas->isAlive || !$spacecake->isAlive ? 'disabled' : '' ?>>Spacekaas Uses KaasBeam</button>
        <button type="submit" name="action" value="spacecake_beam" <?= !$spacecake->isAlive || !$spacekaas->isAlive ? 'disabled' : '' ?>>Spacecake Uses CakeBeam</button>
    </form>

    <!-- Save and Load buttons -->
    <form method="post" action="">
        <button type="submit" name="action" value="save">Save Progress</button>
        <button type="submit" name="action" value="load">Load Progress</button>
    </form>

    <!-- Reset button -->
    <?php if (!$spacekaas->isAlive || !$spacecake->isAlive): ?>
        <h3>Battle Over!</h3>
        <?php if (!$spacekaas->isAlive): ?>
            <p>Spacekaas has been defeated!</p>
        <?php elseif (!$spacecake->isAlive): ?>
            <p>Spacecake has been defeated!</p>
        <?php endif; ?>

        <form method="post" action="">
            <button type="submit" name="action" value="reset">Reset Battle</button>
        </form>
    <?php endif; ?>
</body>

</html>
