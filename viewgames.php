<!DOCTYPE html>
<html>
<body>

    <h2>Games</h2>

    <?php
        include 'games-select.php';
        
        if(isset($_POST['select-game'])) {
            $gameid = $_POST['select-game'];
            unset($_POST['select-game']);

            if(isset($_POST['update-game'])) {
                $newcity = $_POST['update-game-newcity'];
                unset($_POST['update-game']);
                unset($_POST['update-game-newcity']);

                if($newcity == "New City") {
                    echo "You must enter a valid city name";
                }
                else {
                    pg_query("UPDATE game SET city = '{$newcity}' WHERE gameid = {$gameid}");
                    // Display game data for the edited game
                    echo '<script> document.getElementById("view-game-btn").click(); </script>';
                }
            }

            // Display game data for the selected game
            // Query for the game the user has selected
            $result = pg_query("select 
                    game.gameid, 
                    game.city as gamecity,
                    gamedate,
                    headofficialid,
                    team.city as team1city, 
                    team.teamname as team1, 
                    team1score,
                    team2score,
                    team2.teamname as team2,
                    team2.city as team2city

                from team, team as team2, game
                where
                    game.gameid = {$gameid}
                    and
                    team1id = team.teamid 
                    and 
                    team2id = team2.teamid
                ;");

            // This query only has one row, which contains all the game data
            $gamedata = pg_fetch_array($result);
            pg_free_result($result);
            // Now look up the officials for this game
            $result = pg_query("select firstname, lastname, official.officialid 
                from officiates, official
                where 
                    official.officialid = officiates.officialid 
                    and 
                    gameid = {$gameid};");
           
            // Create a <br>-delimted list of officials. Head official in bold.
            $official_names = "";
            while($row = pg_fetch_array($result)) {
                $is_head = $row['officialid'] == $gamedata['headofficialid'];
                if($is_head) {
                    $official_names .= "<b>";
                }
                $official_names .= $row['firstname']." ".$row['lastname']."&nbsp;<br>";    
                if($is_head) {
                    $official_names .= "</b>";
                }
            }
            pg_free_result($result);

            // Combine teamcity and teamname into full team names, eg "Toronto Maple Leafs"
            $team1_fullname = $gamedata['team1city']." ".$gamedata['team1'];
            $team2_fullname = $gamedata['team2city']." ".$gamedata['team2'];

            // and bold the winning team 
            if((int)$gamedata['team1score'] > (int)$gamedata['team2score']) {
                $team1_fullname = "<b>".$team1_fullname."</b>";
            }
            else if((int)$gamedata['team1score'] < (int)$gamedata['team2score']) {
                $team2_fullname = "<b>".$team2_fullname."</b>";
            }
            // Do nothing for ties (if there is data from that era!)
           
            // Draw the Game Data table (one row headers, one row data).
            echo '<table>';
            echo '<th>Game ID</th>
                <th>City</th>
                <th>Date</th>
                <th>Officials</th>
                <th>Team 1</th>
                <th>Score</th>
                <th>Score</th>
                <th>Team 2</th>';
            echo "<tr>";
            echo "<td>{$gamedata['gameid']}</td>
                <td>{$gamedata['gamecity']}</td>
                <td>{$gamedata['gamedate']}</td>
                <td>{$official_names}</td>
                <td>{$team1_fullname}</td>
                <td class=\"center-text\">{$gamedata['team1score']}</td>
                <td class=\"center-text\">{$gamedata['team2score']}</td>
                <td>{$team2_fullname}</td>";
            echo "</tr></table>";
        }
    ?>
</body>
</html>
