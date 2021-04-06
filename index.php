<?php

require_once 'vendor/autoload.php';
require_once 'db.php';

$sql = 'SELECT * FROM contacts ORDER BY lastname, firstname';

try {
    $st = $db->query($sql, PDO::FETCH_ASSOC);
} catch (Exception $exception) {
    die ("Can't execute query '$sql': '{$exception->getMessage()}'");
}

?>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
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
                <td><button class="edit">Edit</button></td>
                <td><button class="delete">Delete</button></td>
            </tr>
        <?php
        endforeach;
        ?>
        <tr>
            <td colspan="5"><button id="new_contact">Add new</button></td>
        </tr>
        </tbody>
    </table>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script type="application/javascript">
    $('#new_contact').click(function() {
        alert('Showing popup form!');
    });
    $('.edit').click(function() {
        alert('Editing ' + this.parentNode.parentNode.children.item(2).textContent);
    })
    $('.delete').click(function() {
        alert('Deleting ' + this.parentNode.parentNode.children.item(2).textContent);
    })
</script>