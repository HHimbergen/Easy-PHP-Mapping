<style>
    body {
    background: #dadada; }
    #tile {
    background: green; 
    width: 40px;
    border: 1px grey solid; 
    border-right: none; 
    height: 40px; 
    float: left; }
    #tilex {
    background: red; 
    width: 39px;
    border: 1px black solid; 
    height: 40px; 
    float: left; }
    #clearer {
    clear: both; }
    #block {
    width: 39px;
    border: 1px black solid; 
    height: 40px; 
    float: left;
    background: black; }
    #game {
    float: left; }
    #editor {
    float: right; }
</style>
<div id="game">
<?php
session_start();
error_reporting(0);
/* Show Tiles */
$tilex = 15;
$tiley = 20;
$tiles = $tilex * $tiley;

$fieldsprow = 0;
$fieldrow = 1;
$actfield = 1;
$objects = array();
$objects[] = "5|1";
$objects[] = "1|2";
$objects[] = "2|2";
$objects[] = "3|2";
$objects[] = "5|2";
$objects[] = "2|7";
$objects[] = "3|7";
$objects[] = "3|8";

if(!isset($_SESSION['pos'])) {
    $_SESSION['pos'] = "1|1";
} else {
    $posreq = explode("|", $_GET['pos']);
    $actreq = explode("|", $_SESSION['pos']);
    if($posreq[0] == $actreq[0]-1 || $posreq[0] == $actreq[0]+1 || $posreq[0] == $actreq[0]) {
        if($posreq[1] == $actreq[1]-1 || $posreq[1] == $actreq[1]+1 || $posreq[1] == $actreq[1]) {
            if(!in_array($_GET['pos'], $objects)) {
            $_SESSION['pos'] = $_GET['pos']; } else {
                header("Location: ?pos=".$_SESSION['pos']);
            }
        }
    }
}
    $playerpos = $_SESSION['pos']; 
    $playercord = explode("|", $playerpos);
    
for($fields = 0; $fields < $tiles; $fields++) {
    if($playercord[0] == $fieldrow && $playercord[1] == $actfield) { 
        echo '<div class="'.$actfield.' cord '.$fieldrow.'" id="tilex"></div>';
    } else {
        if(in_array($fieldrow."|".$actfield, $objects)) {
            echo '<div class="'.$actfield.' cord '.$fieldrow.'" id="block"></div>';   
        } else {
            echo '<a href="?pos='.$fieldrow.'|'.$actfield.'"><div class="'.$actfield.' cord '.$fieldrow.'" id="tile"></div></a>';   
        }
    } 
    
    $fieldsprow++;
    $actfield++;
    if($fieldsprow == $tiley) {
        echo '<div id="clearer"></div>';
        $fieldsprow = 0;
        $actfield = 1;
        $fieldrow++;
    }
}

?>
</div>
Set as Block