<!DOCTYPE html>
<html>
<body>

    <h2>Officials</h2>

    <?php
        $result = pg_query("SELECT officialid, firstname, lastname FROM official ORDER BY lastname;");

        echo '<table>';
        echo '<th>Official ID</th><th>First Name</th><th>Last Name</th>';
        while($row = pg_fetch_array($result)) {
            echo '<tr>';
            echo "<td>{$row['officialid']}</td><td>{$row['firstname']}</td><td>{$row['lastname']}</td>";
            echo '</tr>';
        }
        echo '</table>';

        pg_free_result($result);
    ?>
</body>
</html>
