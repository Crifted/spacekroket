// BaseShip.php: Algemene logica voor alle schepen
// - Eigenschappen: ammo, hitPoints, isAlive
// - Functies: hitpunten verwerken, opslaan, laden, resetten
// - Wordt uitgebreid door CheeseShip en CakeShip


<?php
// Definiëring van de Spaceship klasse.
// Dit is de basis voor alle ruimteschepen. Andere klassen (zoals Spacekaas en Spacecake)
// kunnen deze klasse gebruiken om algemene eigenschappen en functies te erven.
class Spaceship
{
    // Properties (eigenschappen) die elk ruimteschip heeft:
    public bool $isAlive;    // Houdt bij of het ruimteschip nog "leeft" (true of false).
    public int $hitPoints;   // Het aantal "levenspunten" van het ruimteschip.
    public int $ammo;        // Hoeveel munitie het ruimteschip heeft.

    // Constructor: deze functie wordt automatisch aangeroepen wanneer een nieuw
    // object van deze klasse wordt gemaakt. Het stelt standaardwaarden in.
    public function __construct(
        $ammo = 100,        // Het ruimteschip begint standaard met 100 munitie.
        $hitPoints = 100    // Het ruimteschip begint standaard met 100 levenspunten.
    ) {
        $this->ammo = $ammo;          // Stel de munitie in.
        $this->hitPoints = $hitPoints; // Stel de levenspunten in.
        $this->isAlive = true;        // Het ruimteschip leeft standaard.
    }

    // Functie om schade te verwerken.
    // Als het ruimteschip wordt geraakt, wordt deze functie aangeroepen.
    public function hit($damage)
    {
        // Controleer of de schade de levenspunten tot onder 0 brengt.
        if ($this->hitPoints - $damage > 0) {
            $this->hitPoints -= $damage; // Verminder de levenspunten met de schade.
        } else {
            $this->isAlive = false;     // Als de levenspunten 0 of minder worden, is het ruimteschip "dood".
        }
    }

    // Functie om de status van het ruimteschip op te slaan in een bestand.
    public function save($filePath)
    {
        // Maak een array met de huidige status van het ruimteschip.
        $data = [
            'ammo' => $this->ammo,           // Opslaan hoeveel munitie er nog is.
            'hitPoints' => $this->hitPoints, // Opslaan hoeveel levenspunten er nog zijn.
            'isAlive' => $this->isAlive,     // Opslaan of het ruimteschip nog leeft.
        ];

        // Zet de status om in een string en sla deze op in een bestand.
        file_put_contents($filePath, serialize($data));
        echo "Spaceship saved  <br>"; // Laat een bericht zien dat het opslaan gelukt is.
    }

    // Functie om een eerder opgeslagen status van het ruimteschip te laden.
    public function load($loadPath)
    {
        // Controleer of het bestand bestaat.
        if (file_exists($loadPath)) {
            // Haal de opgeslagen data op en zet deze om naar een array.
            $data = unserialize(file_get_contents($loadPath));

            // Herstel de eigenschappen van het ruimteschip met de geladen data.
            $this->isAlive = $data['isAlive'];
            $this->hitPoints = $data['hitPoints'];
            $this->ammo = $data['ammo'];
            echo "Spaceship state loaded!<br>"; // Laat een bericht zien dat het laden gelukt is.
        } else {
            // Als het bestand niet bestaat, laat een foutmelding zien.
            echo "No save file found!<br>";
        }
    }

    // Functie om het ruimteschip te resetten naar de beginstatus.
    public function reset(): void
    {
        $this->hitPoints = 100; // Zet de levenspunten terug naar 100.
        $this->ammo = 100;      // Zet de munitie terug naar 100.
        $this->isAlive = true;  // Zorg dat het ruimteschip weer "leeft".
    }
}
?>
