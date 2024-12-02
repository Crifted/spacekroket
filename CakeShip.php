// CakeShip.php: Definieert het CakeShip
// - Eigenschappen: ammo, hitPoints, cakeBullet, cakeBeam
// - Functies: schieten, beam gebruiken, hitpunten verminderen, opslaan/laden


<?php 

// Laad het bestand waarin de Spaceship-klasse is gedefinieerd.
// De Spacecake-klasse breidt de Spaceship-klasse uit (erft van de Spaceship-klasse).
include_once 'BaseShip.php';


// Definieer de Spacecake-klasse.
// Dit is een "child class" van Spaceship, wat betekent dat het alle eigenschappen en methoden van Spaceship overneemt.
class Spacecake extends Spaceship {

    public int $cakeBullet;  // Eigenschap om het aantal CakeBullets van Spacecake bij te houden.
    public int $cakeBeam;    // Eigenschap om het aantal CakeBeams van Spacecake bij te houden.

    // Constructor: Deze functie wordt aangeroepen wanneer een nieuw Spacecake-object wordt gemaakt.
    public function __construct($isAlive, $hitPoints, $ammo) {
        // Stel de standaardwaarden in die uniek zijn voor Spacecake.
        $this->cakeBullet = 33; // Spacecake begint met 33 CakeBullets.
        $this->cakeBeam = 3;    // Spacecake begint met 3 CakeBeams.

        // Roep de constructor van de parent class (Spaceship) aan.
        // Dit zorgt ervoor dat de algemene eigenschappen zoals $ammo en $hitPoints ook worden ingesteld. (eigen eigenschappen)
        parent::__construct($ammo, $hitPoints);
    }

    // Methode: Hiermee kan Spacecake een CakeBullet afvuren.
    public function shootCakeBullet(): int {
        $cakeDamage = 10;  // Elke CakeBullet doet 10 schade.
        $cakeUsage = 1;    // Het schieten van een CakeBullet kost 1 "bullet".

        // Controleer of Spacecake genoeg CakeBullets heeft.
        if ($this->cakeBullet >= $cakeUsage) {
            // Als er genoeg zijn, verlaag het aantal CakeBullets met 1.
            $this->cakeBullet -= $cakeUsage;
            return $cakeDamage;  // Keer de hoeveelheid schade terug.
        } else {
            // Als er geen CakeBullets meer zijn, geef een melding en keer 0 schade terug.
            echo "No CakeBullets left!<br>";
            return 0; // Geen schade, want er zijn geen kogels.
        }
    }

    // Methode: Hiermee kan Spacecake de CakeBeam afvuren.
    public function CakeBeam(): int {
        $beamUsage = 1;  // Het gebruik van de CakeBeam kost 1 "beam".
        $damage = 33;    // Elke CakeBeam doet 33 schade.

        // Controleer of Spacecake genoeg CakeBeams heeft.
        if ($this->cakeBeam >= $beamUsage) {
            // Als er genoeg zijn, verlaag het aantal CakeBeams met 1.
            $this->cakeBeam -= $beamUsage;
            return ($beamUsage * $damage); // Keer de totale schade terug (33 in dit geval).
        } else {
            // Als er geen CakeBeams meer zijn, geef een melding en keer 0 schade terug.
            echo "No CakeBeam left!<br>";
            return 0; // Geen schade, want er zijn geen beams.
        }
    }
}
?>
