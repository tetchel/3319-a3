<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>tetchel's hockeydb</title>

    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
    <h1 class="center-text">tetchel's hockeydb</h1>
    
    <?php
        include 'connectdb.php'
    ?>
   
    <?php
        include 'newteam.php'
    ?>

    <?php
        include 'removeteam.php'
    ?>
    
    <?php
        include 'showteams.php'
    ?>

    <?php
        include 'viewgames.php'
    ?>

    <?php
        include 'viewofficials.php'
    ?>
    
    <?php
        include 'leafs.php'
    ?>

    <?php pg_close($connection) ?>
</body>
</html>
