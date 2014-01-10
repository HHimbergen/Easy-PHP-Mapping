<html>
    <head>
        <title>Mapengine</title>
        <link rel="stylesheet" href="assets/default.css">
    </head>
    <body>
        <div id="game">
            <?php
                error_reporting(0);
                Include("classes/general.class.php");
                $gen = new General(6); 
                $gen->showMap();
            ?>
        </div>        
    </body>
</html>



