 <div>
    <form action="<?php $_PHP_SELF ?>" method="POST" style="display:inline;">
        <input type="submit" id="orderbyteam" name="orderbyteam" value="Order by Team"/>
    </form>
    <form action="<?php $_PHP_SELF ?>" method="POST" style="display:inline;">
        <input type="submit" id="orderbycity" name="orderbycity" value="Order by City"/>
    </form>
</div>


<?php
    if(isset($_POST['orderbycity'])) {
        $query = 'SELECT * FROM team ORDER BY city;';
        //unset($_POST['orderbyteam']);
    }
    else {
        $query = 'SELECT * FROM team ORDER BY teamname;';
        //unset($_POST['orderbycity']);
    }

    $result = pg_query($query);
    if (!$result) {
        die ("Database query failed!");
    }

    echo "<h2>Teams</h2>";
    echo "<table>";
    echo "<th>Team ID</th><th>City</th><th>Team Name</th>";
    while ($row = pg_fetch_array($result)) {
        echo "<tr>";
        echo    "<td>".$row['teamid']."</td>".
                "<td>".$row['city']."</td>".
                "<td>".$row['teamname']."</td>";
        echo "</tr>";
    }
    echo "</table>";
    pg_free_result($result);
?>
