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
    <table id="contact_table">
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
        </tbody>
    </table>
    <button id="new_contact">New</button>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script type="application/javascript">
    $('#new_contact').click(function() {
        $('#contact_table > tbody:last-child').append(
            '<tr>' +
                '<td><input id="firstname" name="firstname"/></td>' +
                '<td><input id="lastname" name="lastname"/></td>' +
                '<td><input id="email" name="email"/></td>' +
                '<td><button id="confirm">Confirm</button></td>' +
                '<td><button id="cancel">Cancel</td>' +
            '</tr>'
        );
        $('#confirm').click(function() {
            $.post('new.php', {
                firstname: $('#firstname').val(),
                lastname: $('#lastname').val(),
                email: $('#email').val()
            });
        });
    });
    $('.edit').click(function() {
        let originalFirstName = this.parentNode.parentNode.children.item(0).textContent;
        let originalLastName = this.parentNode.parentNode.children.item(1).textContent;
        let originalEmail = this.parentNode.parentNode.children.item(2).textContent;
        let editRow = '<tr>' +
            '<td><input id="firstname" name="firstname" value="' + originalFirstName + '"/></td>' +
            '<td><input id="lastname" name="lastname" value="' + originalLastName + '"/></td>' +
            '<td><input id="email" name="email" value="' + originalEmail + '"/></td>' +
            '<td><button id="confirm">Confirm</button></td>' +
            '<td><button id="cancel">Cancel</td>' +
        '</tr>';
        let prevRow = $(this).closest('tr').previousSibling;
        let oldRow = $(this).closest('tr').clone();
        $(this).closest('tr').remove();

        if (prevRow) {
            prevRow.appendChild($(editRow));
        } else {
           $('#contact_table > tbody').append(editRow);
        }
        $('#confirm').click(function () {
            alert('Confirming update');
            // ajax call
        });
        $('#cancel').click(function() {
            let prevRow = $(this).closest('tr').previousSibling;
            $(this).closest('tr').remove();

            if (prevRow) {
                prevRow.appendChild(oldRow);
            } else {
                $('#contact_table > tbody').append(oldRow);
            }
        });
    })
    $('.delete').click(function() {
        alert('Deleting ' + this.parentNode.parentNode.children.item(2).textContent);
    })
</script>