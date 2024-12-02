// index.php: De hoofdpagina van het spel
// - Toont de status van CheeseShip en CakeShip
// - Verwerkt acties zoals schieten, beams, opslaan, laden, en resetten
// - Start sessies om scheepsdata bij te houden


<?php
// Hier worden de bestanden ingeladen waarin de klassen Spacekaas en Spacecake zijn gedefinieerd.
// Deze bestanden zijn nodig om objecten van Spacekaas en Spacecake te maken en ermee te werken.
include_once 'CheeseShip.php';
include_once 'CakeShip.php';


// Start een sessie zodat gegevens van Spacekaas en Spacecake opgeslagen blijven,
// zelfs als de pagina opnieuw wordt geladen.
session_start();

// Definieer de bestandsnamen waarin de status van Spacekaas en Spacecake wordt opgeslagen.
// Deze bestanden worden gebruikt om de voortgang op te slaan of te laden.
$saveFilePathKaas = 'spacekaas_save.txt'; // Bestandsnaam voor Spacekaas.
$saveFilePathCake = 'spacecake_save.txt'; // Bestandsnaam voor Spacecake.

// Controleer of de objecten Spacekaas en Spacecake al in de sessie bestaan.
// Dit betekent dat we kijken of er al schepen zijn gemaakt voor deze sessie.
if (!isset($_SESSION['spacekaas']) || !isset($_SESSION['spacecake'])) {
    // Als de objecten nog niet bestaan, maken we nieuwe objecten aan met standaardwaarden.
    $_SESSION['spacekaas'] = new Spacekaas(true, 100, 100); // Spacekaas begint met 100 HP en 100 ammo.
    $_SESSION['spacecake'] = new Spacecake(true, 100, 100); // Spacecake begint met 100 HP en 100 ammo.
}

// Haal de objecten Spacekaas en Spacecake uit de sessie zodat we ermee kunnen werken.
// Dit betekent dat we de opgeslagen schepen ophalen en ze klaarmaken voor gebruik.
$spacekaas = $_SESSION['spacekaas'];
$spacecake = $_SESSION['spacecake'];

// Controleer of de gebruiker een actie heeft uitgevoerd (bijvoorbeeld schieten of opslaan).
if (isset($_POST['action'])) {
    // Gebruik een switch-statement om te bepalen welke actie de gebruiker heeft gekozen.
    switch ($_POST['action']) {
        case 'spacekaas_shoot': // Als de gebruiker ervoor kiest dat Spacekaas schiet:
            // Bereken de schade die Spacekaas aan Spacecake doet.
            $damage = $spacekaas->shootKaasBullet();
            // Breng de schade aan Spacecake toe.
            $spacecake->hit($damage);
            break;

        case 'spacecake_shoot': // Als de gebruiker ervoor kiest dat Spacecake schiet:
            // Bereken de schade die Spacecake aan Spacekaas doet.
            $damage = $spacecake->shootCakeBullet();
            // Breng de schade aan Spacekaas toe.
            $spacekaas->hit($damage);
            break;

        case 'spacekaas_beam': // Als de gebruiker ervoor kiest dat Spacekaas de KaasBeam gebruikt:
            // Bereken de schade van de KaasBeam.
            $damage = $spacekaas->KaasBeam();
            // Breng de schade aan Spacecake toe.
            $spacecake->hit($damage);
            break;

        case 'spacecake_beam': // Als de gebruiker ervoor kiest dat Spacecake de CakeBeam gebruikt:
            // Bereken de schade van de CakeBeam.
            $damage = $spacecake->CakeBeam();
            // Breng de schade aan Spacekaas toe.
            $spacekaas->hit($damage);
            break;

        case 'save': // Als de gebruiker ervoor kiest om de game op te slaan:
            // Sla de status van Spacekaas en Spacecake op in hun respectieve bestanden.
            $spacekaas->save($saveFilePathKaas);
            $spacecake->save($saveFilePathCake);
            echo "Game opgeslagen!<br>"; // Laat de gebruiker weten dat de game is opgeslagen.
            break;

        case 'load': // Als de gebruiker ervoor kiest om een eerder opgeslagen game te laden:
            // Controleer of de opslagbestanden bestaan.
            if (file_exists($saveFilePathKaas) && file_exists($saveFilePathCake)) {
                // Laad de status van Spacekaas en Spacecake uit de bestanden.
                $spacekaas->load($saveFilePathKaas);
                $spacecake->load($saveFilePathCake);
                echo "Game geladen!<br>"; // Laat de gebruiker weten dat de game is geladen.
            } else {
                echo "Geen opgeslagen game gevonden!<br>"; // Laat weten dat er geen bestanden zijn.
            }
            break;

        case 'reset': // Als de gebruiker ervoor kiest om het spel te resetten:
            // Vernietig de huidige sessie om alle gegevens te verwijderen.
            session_destroy();
            // Stuur de gebruiker terug naar de startpagina (index.php) om opnieuw te beginnen.
            header("Location: index.php");
            exit(); // Stop het script hier om verdere verwerking te voorkomen.
    }
}

// Update de sessie met de nieuwste status van Spacekaas en Spacecake.
// Dit zorgt ervoor dat wijzigingen (zoals minder HP of ammo) worden opgeslagen.
$_SESSION['spacekaas'] = $spacekaas;
$_SESSION['spacecake'] = $spacecake;
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spacekaas vs Spacecake</title>
    <style>
        /* Algemene stijl voor de pagina */
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom right, #1a202c, #4a5568); /* Mooie grijs-blauwe gradient */
            font-family: 'Roboto', Arial, sans-serif; /* Modern en strak lettertype */
            color: #edf2f7; /* Zachte witte kleur voor tekst */
            text-align: center;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Kopteksten (h1, h2) */
        h1 {
            font-size: 50px;
            font-weight: bold;
            color: #e2e8f0; /* Lichte grijs-witte kleur */
            text-transform: uppercase;
            margin-bottom: 20px;
            letter-spacing: 3px; /* Meer ruimte tussen letters */
        }

        h2 {
            font-size: 28px;
            font-weight: bold;
            color: #cbd5e0; /* Nog iets donkerder grijs-wit */
            text-transform: uppercase;
            margin: 10px 0;
            letter-spacing: 1.5px;
        }

        /* Tekst (p) */
        p {
            font-size: 18px;
            line-height: 1.8; /* Ruimte tussen regels */
            margin: 10px 0;
            color: #e2e8f0; /* Zacht wit */
        }

        /* Stijl voor knoppen */
        button {
            background: linear-gradient(to right, #6b46c1, #805ad5); /* Paars-blauw gradient */
            border: none;
            border-radius: 8px; /* Ronde hoeken */
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            margin: 10px;
            text-transform: uppercase; /* Hoofdletters */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtiele schaduw */
            transition: transform 0.2s, box-shadow 0.2s; /* Animatie bij hover */
        }

        /* Hover-effect voor knoppen */
        button:hover {
            transform: scale(1.1); /* Knoppen worden iets groter */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Meer schaduw */
        }

        /* Stijl voor uitgeschakelde knoppen */
        button:disabled {
            background: #718096; /* Grijze kleur voor uitgeschakelde knoppen */
            cursor: not-allowed; /* Pijltje verandert in "niet mogelijk" */
        }

        /* Statuskaart */
        .status {
            background: rgba(0, 0, 0, 0.6); /* Semi-transparante achtergrond */
            padding: 20px;
            border-radius: 10px; /* Ronde hoeken */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Schaduw voor diepte */
            width: 90%;
            max-width: 600px;
            margin-bottom: 20px;
        }

        /* Horizontale lijn */
        hr {
            border: none;
            height: 2px;
            background: #e2e8f0; /* Zachte witte lijn */
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <h1>Spacekaas vs Spacecake</h1>

    <!-- Status van beide schepen -->
    <div class="status">
        <h2>Spacekaas Status:</h2>
        <p>Ammo: <?= $spacekaas->ammo ?></p>
        <p>Hit Points: <?= $spacekaas->hitPoints ?></p>
        <p>Kaas Bullets: <?= $spacekaas->kaasBullet ?></p>
        <p>Kaas Beam: <?= $spacekaas->kaasBeam ?></p>
        <p>Alive: <?= $spacekaas->isAlive ? 'Yes' : 'No' ?></p>
        <hr>
        <h2>Spacecake Status:</h2>
        <p>Ammo: <?= $spacecake->ammo ?></p>
        <p>Hit Points: <?= $spacecake->hitPoints ?></p>
        <p>Cake Bullets: <?= $spacecake->cakeBullet ?></p>
        <p>Cake Beam: <?= $spacecake->cakeBeam ?></p>
        <p>Alive: <?= $spacecake->isAlive ? 'Yes' : 'No' ?></p>
    </div>

    <!-- Actieknoppen -->
    <form method="post">
        <button type="submit" name="action" value="spacekaas_shoot" <?= !$spacekaas->isAlive || !$spacecake->isAlive ? 'disabled' : '' ?>>Spacekaas Shoots</button>
        <button type="submit" name="action" value="spacecake_shoot" <?= !$spacecake->isAlive || !$spacekaas->isAlive ? 'disabled' : '' ?>>Spacecake Shoots</button>
        <br>
        <button type="submit" name="action" value="spacekaas_beam" <?= !$spacekaas->isAlive || !$spacecake->isAlive ? 'disabled' : '' ?>>Spacekaas Uses KaasBeam</button>
        <button type="submit" name="action" value="spacecake_beam" <?= !$spacecake->isAlive || !$spacekaas->isAlive ? 'disabled' : '' ?>>Spacecake Uses CakeBeam</button>
        <br>
        <button type="submit" name="action" value="save">Save Progress</button>
        <button type="submit" name="action" value="load">Load Progress</button>
        <button type="submit" name="action" value="reset">Reset</button>
    </form>

    <?php if (!$spacekaas->isAlive || !$spacecake->isAlive): ?>
        <h2>Game Over!</h2>
        <?php if (!$spacekaas->isAlive): ?>
            <p>Spacekaas is verslagen!</p>
        <?php elseif (!$spacecake->isAlive): ?>
            <p>Spacecake is verslagen!</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
