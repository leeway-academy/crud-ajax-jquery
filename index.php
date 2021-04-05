<?php

require_once 'db.php';

$sql = 'SELECT * FROM contacts ORDER BY lastname, firstname';

try {
    $st = $db->query($sql, PDO::FETCH_ASSOC);
} catch (Exception $exception) {
    die ("Can't execute query '$sql': '{$exception->getMessage()}'");
}


