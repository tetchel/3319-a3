<?php 

    // Fetch game data to populate the drop-down with
    $result = pg_query("SELECT gameid, city, gamedate FROM game ORDER BY gameid");

    $all_games = array();
    while($gamedata = pg_fetch_array($result)) {
        array_push($all_games, $gamedata['gameid']." - ".$gamedata['city'].", ".$gamedata['gamedate']);
    }
    pg_free_result($result);
    
    // Create a dropdown listing game data
    echo '<form name="select-game" method="post">';
    echo '<label for="select-game">Select GameID:&nbsp;&nbsp;</label>';
    echo '<select name="select-game">';
    foreach($all_games as $game) {
        // Extract the game ID from the game data
        $id = explode(' ', $game)[0];
        // If they did POST something, make sure the same game is still selected
        $selected = "";
        if(isset($_POST['select-game']) && $id == $_POST['select-game']) {
            $selected = 'selected="selected"'; 
        }
        echo "<option {$selected} value=\"{$id}\">{$game}</option>";
    }
    echo '</select>&nbsp;&nbsp;&nbsp;';
    echo '<input type="submit" id="view-game-btn" name="submit" value="View Game Data"/>';
    echo '<input type="submit" name="update-game" value="Update Game City" style="margin-left:5px"/>';
    echo '<input type="text" name="update-game-newcity" value="New City" maxlength="15" style="margin-left:5px"/>';
    echo '</form>';
?>
