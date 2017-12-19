<!DOCTYPE html>
<html>
<body>

    <h2>The Leafs' Curse</h2>

    <?php
        include 'leafs-select.php';

        if(isset($_POST['select-leafs'])) {
            $option = $_POST['select-leafs'];

            if($option == 0) {
                // show the scores for all Leafs games and opponents name and city.
                $result = pg_query("SELECT
                        team.teamname AS team1, team.city AS team1city, team1score,
                        team2.teamname AS team2, team2.city AS team2city, team2score
                    FROM game, team, team AS team2
                    WHERE
                        team1id = team.teamid 
                        AND (
                            team1id in (SELECT teamid FROM team WHERE teamname = 'Maple Leafs')
                            OR 
                            team2id in (SELECT teamid FROM team WHERE teamname = 'Maple Leafs')
                        )
                        AND team2id = team2.teamid
                    ");

                echo '<table>';
                echo '<th>Leafs Score</th><th>Opponent Score</th><th>Opponent</th>';
                while($row = pg_fetch_array($result)) {
                    $leafscore = -1;
                    $oppscore = -1;
                    $oppname = "n/a";
                    // We already know that either team 1 or team 2 is the leafs from the query
                    if($row['team1'] == "Maple Leafs") {
                        $leafscore = $row['team1score'];
                        $oppscore  = $row['team2score'];
                        $oppname   = $row['team2city'].' '.$row['team2'];
                    }
                    else {
                        $leafscore = $row['team2score'];
                        $oppscore  = $row['team1score'];
                        $oppname   = $row['team1city'].' '.$row['team1'];
                    }

                    echo '<tr>';
                    echo "<td>{$leafscore}</td><td>{$oppscore}</td><td>{$oppname}</td>";
                    echo '</tr>';
                }
                echo '</table>';
                pg_free_result($result);
            }
            else if($option == 1) {
                // Show the official who reffed the most leafs games
                $result = pg_query("SELECT count(official.officialid) c, firstname, lastname
                    FROM game, team, team AS team2, official, officiates
                    WHERE
                        team1id = team.teamid 
                        AND (
                            team1id in (SELECT teamid FROM team WHERE teamname = 'Maple Leafs')
                            OR 
                            team2id in (SELECT teamid FROM team WHERE teamname = 'Maple Leafs')
                        )
                        AND team2id = team2.teamid
                        AND game.gameid = officiates.gameid
                        AND official.officialid = officiates.officialid
                        group by official.officialid
                        order by c desc");

                echo 'The official(s) who reffed the most leafs games is/are: ';
                // count for top official - could be more than one
                $count = pg_fetch_array($result, 0)['c'];

                while($row = pg_fetch_array($result)) {
                    if($row['c'] == $count) {
                        echo "{$row['firstname']} {$row['lastname']}, ";
                    }
                    else {
                        // no more officials that reffed as many games (since they're sorted)
                        break;
                    }
                }
                pg_free_result($result);
                echo "with {$count} Leafs games officiated.";
            }
            else if($option == 2) {
                // Show the official who reffed the most leafs WINS
                // Query is just slightly different - now check that leafs score > opponents
                $result = pg_query("SELECT count(official.officialid) c, firstname, lastname
                    FROM game, team, team AS team2, official, officiates
                    WHERE
                        team1id = team.teamid 
                        AND (
                                (team1id in (SELECT teamid FROM team WHERE teamname = 'Maple Leafs')
                                    AND team1score > team2score
                                )
                            OR 
                                (team2id in (SELECT teamid FROM team WHERE teamname = 'Maple Leafs')
                                    AND team2score > team1score
                                )
                        )
                        AND team2id = team2.teamid
                        AND game.gameid = officiates.gameid
                        AND official.officialid = officiates.officialid
                        group by official.officialid
                        order by c desc
                    ");

                echo 'The official(s) who reffed the most leafs wins is/are: ';
                // count for top official - could be more than one
                $count = pg_fetch_array($result, 0)['c'];

                while($row = pg_fetch_array($result)) {
                    if($row['c'] == $count) {
                        echo "{$row['firstname']} {$row['lastname']}, ";
                    }
                    else {
                        // no more officials that reffed as many wins (since they're sorted)
                        break;
                    }
                }
                pg_free_result($result);
                echo "with {$count} Leafs wins officiated.";
            }
            else if($option == 3) {
                // Show the official who reffed the most leafs LOSSES
                // Query is just slightly different - now check that leafs score < opponents
                $result = pg_query("SELECT count(official.officialid) c, firstname, lastname
                    FROM game, team, team AS team2, official, officiates
                    WHERE
                        team1id = team.teamid 
                        AND (
                                (team1id in (SELECT teamid FROM team WHERE teamname = 'Maple Leafs')
                                    AND team1score < team2score
                                )
                            OR 
                                (team2id in (SELECT teamid FROM team WHERE teamname = 'Maple Leafs')
                                    AND team2score < team1score
                                )
                        )
                        AND team2id = team2.teamid
                        AND game.gameid = officiates.gameid
                        AND official.officialid = officiates.officialid
                        group by official.officialid
                        order by c desc
                    ");

                echo 'The official(s) who reffed the most leafs losses is/are: ';
                // count for top official - could be more than one
                $count = pg_fetch_array($result, 0)['c'];

                while($row = pg_fetch_array($result)) {
                    if($row['c'] == $count) {
                        echo "{$row['firstname']} {$row['lastname']}, ";
                    }
                    else {
                        // no more officials that reffed as many wins (since they're sorted)
                        break;
                    }
                }
                pg_free_result($result);
                echo "with {$count} Leafs losses officiated.";
            }
        }
    ?>
</body>
</html>
