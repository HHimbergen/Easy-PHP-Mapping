<?php
class General {
    private $mapsize;
     
    public function __construct($mapsize, $plcoord) {
        session_start();
        self::startInit($mapsize);
    }
    
    /**
     * Initialisiert die generellen Aktionen
     * vor allen anderen Funktionen.
     * @param int $tilerad Kartenfläche
     * @author Dennis Heinrich
     */
    private function startInit($tilerad) {
        self::proofCurrentPos();
        self::setMapsize($tilerad);
        self::setCurrentPos(1, 1);
    }
    
    /**
     * Setzt die Kartengröße für Interaktionen
     * @param int $tilerad Kartengröße a*b
     * @author Dennis Heinrich
     */
    private function setMapsize($tilerad) {
        $this->mapsize = $tilerad;
    }
    
    /**
     * Gibt die aktuelle (gespeicherte) Position wieder
     * @return string Unformatierte Koordinaten
     * @author Dennis Heinrich
     */
    private function getCurrentPos() {
        return $_SESSION['position'];
    }
    
    /**
     *  Prüft ob Position eines Spielers existiert und erstellt eine
     *  falls nicht vorhanden auf (1|1)
     *  @param get $position Nimmt aktuelle Input Position
     *  @author Dennis Heinrich
     */
    private function proofCurrentPos() {
        if(self::getCurrentPos()!==null) {
            self::setCurrentPos(1, 1);
        } else {
            self::setCurrentPos($_GET['position']);
        }
    }
    
    /**
     * Kodiert unformatierte Koordinaten
     * in ein array
     * @param string $coord Unformatierte Koordinaten
     * @return array Formatierte Koordinaten (y|x)
     */
    private function translateCoord($coord) {
        return explode("|", $coord);
    }   
    
    
        /**
        * Prüft ob der nächste Schritt von der Distanz
        * aus erlaubt ist und durchgeführt werden darf
        * @return boolean Gibt true bei Erfolg zurück
        * @category Fortbewegung 
        * @author Dennis Heinrich
        * @param string $position Koordinaten
        * @param int $maxtiles Distanz-Validierung 
        */
    private function onlyTileWalk($position, $maxtiles) {
        $reqcoord = self::translateCoord($_GET['position']);
        $mycoord = self::translateCoord($position);
        $mintilerow = $mycoord[0] - $maxtiles;
        $maxtilerow = $mycoord[0] + $maxtiles;
        $mintileplt = $mycoord[1] - $maxtiles;
        $maxtileplt = $mycoord[1] + $maxtiles;
        if($mintilerow < $reqcoord[0] && $maxtilerow > $reqcoord[0]) {
            if($mintileplt < $reqcoord[1] && $maxtileplt > $reqcoord[1]) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    private function setCurrentPos($x, $y, $typ=1) {
        if($typ==1) {
            if(self::onlyTileWalk($_SESSION['position'], 2)) {
                $_SESSION['position'] = $x."|".$y;
            }
        } else {
            
        }
    }

}