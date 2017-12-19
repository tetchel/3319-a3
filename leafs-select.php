<?php
        // Select form to pick which data about the Leafs' curse to view

        echo '<form name="select-leafs" method="POST">';
        echo '<label for="select-leafs">View Leafs Data:&nbsp;&nbsp;&nbsp;</label>';
        echo '<select name="select-leafs">';

        // If they did POST something, make sure the same option is still selected
        // Messier to do here without the loop, but basically before each option check to see
        // if that was the selected option in the POST, if so set selected=selected
        $notselected = "";
        $isselected = "selected=\"selected\"";
        $selected = $notselected;

        if(isset($_POST['select-leafs']) && $_POST['select-leafs'] == "0") {
            $selected = $isselected;
        }
        echo "<option {$selected} value=\"0\">Leafs Games</option>";

        $selected = $notselected;
        if(isset($_POST['select-leafs']) && $_POST['select-leafs'] == "1") {
            $selected = $isselected; 
        }
        echo "<option {$selected} value=\"1\">Official who has officiated most Leafs GAMES</option>";

        $selected = $notselected;
        if(isset($_POST['select-leafs']) && $_POST['select-leafs'] == "2") {
            $selected = $isselected; 
        }
        echo "<option {$selected} value=\"2\">Official who has officiated most Leafs WINS</option>";

        $selected = $notselected;
        if(isset($_POST['select-leafs']) && $_POST['select-leafs'] == "3") {
            $selected = $isselected; 
        }
        echo "<option {$selected} value=\"3\">Official who has officiated most Leafs LOSSES</option>";
        echo '</select>';
        echo '<input type="submit" name="submit" value="View Leafs Data" style="margin-left:10px"/>';
        echo '</form>';
        // End selection form
?>
