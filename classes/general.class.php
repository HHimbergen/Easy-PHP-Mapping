<?php
class General {
    private $mapsize;
    
    /**
     * Konstuiert das Karten-Objekt
     * Initialisiert Grundlegende Aktionen.
     */
    public function __construct($mapsize) {
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
     * Initialisiert die Karte mit Flächengröße
     * (a*b)
     * @return Map-Template
     * @author Dennis Heinrich 
     */
    public function showMap() {
        $rows = 1;
        $tile = 1;
        for($fields=$tile; $fields <= ($this->mapsize); $fields++) {
            if($rows<=($this->mapsize-1) && $fields==($this->mapsize)) {
                $rows++;
                $fields=0;
                self::showTile($tile, $rows, 1);
                self::newTileRow();
            } else {
                self::showTile($tile, $rows);
            }
        }
    }
    
    /**
     * Erstellt eine neue Zeile auf der Map
     * @return Map-Element
     * @author Dennis Heinrich
     */
    private function newTileRow() {
        echo '<div id="clearer"></div>';
    }
    
    /**
     * Zeigt eine Fliese auf der Map an.
     * @return Map-Element
     * @author Dennis Heinrich
     */
    private function showTile($y, $x, $last=0) {
            echo '<div id="tile"></div>';
        
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
        self::setCurrentPos(1, 1);
        
        self::setCurrentPos($_GET['position']);
        
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
    
    /**
     * Legt die aktuelle Position fest, Admin und
     * Playerbewegung nach Bewegungsmuster.<br>
     * Admin - Jede Koordinate möglich<br>
     * Player - Nur Bewegungsmuster
     * @param int $x X-Koordinate
     * @param int $y Y-Koordinate
     * @param int $typ Bewegungstyp
     * @author Dennis Heinrich
     */
    private function setCurrentPos($x, $y, $typ=1) {
            if(self::onlyTileWalk($_SESSION['position'], 2)) {
                $_SESSION['position'] = $x."|".$y;
            }
    }

}