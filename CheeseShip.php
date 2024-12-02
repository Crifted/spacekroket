// CheeseShip.php: Definieert het CheeseShip
// - Eigenschappen: ammo, hitPoints, kaasBullet, kaasBeam
// - Functies: schieten, beam gebruiken, hitpunten verminderen, opslaan/laden


<?php 

// Laad het bestand waarin de Spaceship-klasse is gedefinieerd.
// De Spacekaas-klasse erft eigenschappen en methoden van de Spaceship-klasse.
include_once 'BaseShip.php';

// Definieer de Spacekaas-klasse.
// Dit is een "child class" van Spaceship, wat betekent dat het alle eigenschappen en methoden van Spaceship overneemt.
class Spacekaas extends Spaceship {

    // Eigenschap om het aantal KaasBullets van Spacekaas bij te houden.
    public int $kaasBullet;

    // Eigenschap om het aantal KaasBeams van Spacekaas bij te houden.
    public int $kaasBeam;

    // Constructor: Deze functie wordt uitgevoerd wanneer je een nieuw Spacekaas-object maakt.
    public function __construct($isAlive, $hitPoints, $ammo) {
        // Roep de constructor van de "parent class" (Spaceship) aan.
        // Dit zorgt ervoor dat algemene eigenschappen zoals $ammo en $hitPoints worden ingesteld.
        parent::__construct($ammo, $hitPoints);

        // Stel de standaardwaarden in die uniek zijn voor Spacekaas.
        $this->kaasBullet = 10; // Spacekaas begint met 10 KaasBullets.
        $this->kaasBeam = 1;    // Spacekaas begint met 1 KaasBeam.
    }

    // Methode: Hiermee kan Spacekaas een KaasBullet afvuren.
    public function shootKaasBullet(): int {
        $kaasDamage = 10;  // Elke KaasBullet doet 10 schade.
        $kaasUsage = 1;    // Het schieten van een KaasBullet kost 1 "bullet".

        // Controleer of Spacekaas genoeg KaasBullets heeft.
        if ($this->kaasBullet >= $kaasUsage) {
            // Als er genoeg zijn, verlaag het aantal KaasBullets met 1.
            $this->kaasBullet -= $kaasUsage;
            return $kaasDamage;  // Retourneer de hoeveelheid schade (10).
        } else {
            // Als er geen KaasBullets meer zijn, toon een melding en retourneer 0 schade.
            echo "No KaasBullets left!<br>";
            return 0; // Geen schade, want er zijn geen kogels.
        }
    }

    // Methode: Hiermee kan Spacekaas de KaasBeam afvuren.
    public function KaasBeam(): int {
        $beamUsage = 1;  // Het gebruik van de KaasBeam kost 1 "beam".
        $damage = 50;    // Elke KaasBeam doet 50 schade.

        // Controleer of Spacekaas genoeg KaasBeams heeft.
        if ($this->kaasBeam >= $beamUsage) {
            // Als er genoeg zijn, verlaag het aantal KaasBeams met 1.
            $this->kaasBeam -= $beamUsage;
            return ($beamUsage * $damage); // Retourneer de totale schade (50 in dit geval).
        } else {
            // Als er geen KaasBeams meer zijn, toon een melding en retourneer 0 schade.
            echo "No KaasBeam left!<br>";
            return 0; // Geen schade, want er zijn geen beams.
        }
    }
}
?>
