<?php

require_once 'db.php';

$sql = 'SELECT * FROM contacts ORDER BY lastname, firstname';

try {
    $st = $db->query($sql, PDO::FETCH_ASSOC);
} catch (Exception $exception) {
    die ("Can't execute query '$sql': '{$exception->getMessage()}'");
}

?>
<html>
<body>
    <table>
        <thead>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody><?php
        foreach ($st->fetchAll() as $contactRow):
            ?>
            <tr>
                <td><?php echo $contactRow['firstname'];?></td>
                <td><?php echo $contactRow['lastname'];?></td>
                <td><?php echo $contactRow['email'];?></td>
            </tr>
        <?php
        endforeach;
        ?>
        <tr>
            <td colspan="3"><button value="Add new" /></td>
        </tr>
        </tbody>
    </table>
</body>
</html>