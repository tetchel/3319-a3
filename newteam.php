<!DOCTYPE html>
<html>
<body>
    <form "<?php $_PHP_SELF ?>" method="POST">
        <input type="submit" id="addteam" name="addteam" value="Add Team"/>

        <input type="text" name="teamcity" id="teamcity" value="Team City" maxlength="15"/>
        <input type="text" name="teamname" id="teamname" value="Team Name" maxlength="20"/>
    </form>

    <?php
        if(isset($_POST['addteam'])) {
            unset($_POST['addteam']);
            $teamname = $_POST["teamname"];
            $teamcity = $_POST["teamcity"];

            $result = pg_query("SELECT teamid FROM team");
            
            $all_ids = array();
            $id = 0;
            while($row = pg_fetch_array($result)) {
                array_push($all_ids, $row[0]);
            }
            //var_dump($all_ids);

            while(in_array((string)$id, $all_ids)) {
                $id++;
            }

            if(ctype_space($teamcity) || ctype_space($teamname)
                || $teamcity == "Team City" || $teamname == "Team Name") {
                echo "You must enter values for both team city and name";
            }
            else {
                pg_query("INSERT INTO team VALUES(".$id.", '".$teamcity."', '".$teamname."')");
                header("Refresh:0");
            }

            pg_free_result($result);
        }
    ?>
</body>
</html>
