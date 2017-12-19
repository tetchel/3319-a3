<!DOCTYPE html>
<html>
<body>
    <form "<?php $_PHP_SELF ?>" method="POST">
        <input type="submit" id="removeteam" name="removeteam" value="Remove Team"/>
        <input type="text" name="teamremove_id" id="teamremove_id" value="TeamID" maxlength="10"/>
    </form>

    <?php
        if(isset($_POST['removeteam'])) {
            unset($_POST['removeteam']);
            $teamid = $_POST["teamremove_id"];

            $result = pg_query("SELECT teamid FROM team");
            
            $all_ids = array();
            while($row = pg_fetch_array($result)) {
                array_push($all_ids, $row[0]);
            }
            //var_dump($all_ids);

            if(in_array((string)$teamid, $all_ids)) {
                // remove
                pg_query("DELETE FROM team WHERE teamid=".$teamid);
                header("Refresh:0");
            }
            else {
                echo "There is no team with ID ".$teamid;
            }
            pg_free_result($result);
        }
    ?>
</body>
</html>
