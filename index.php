<?php

try {
    $db = new PDO('sqlite:mydb.sq3');
} catch (PDOException $exception) {
    die("Can't connect to the database: {$exception->getMessage()}");
}

switch (strtolower($_SERVER['REQUEST_METHOD'])) {
    case 'get':
        $sql = 'SELECT * FROM contacts ORDER BY lastname, firstname';

        try {
            $st = $db->query($sql, PDO::FETCH_ASSOC);
            echo json_encode($st->fetchAll());
        } catch (PDOException $exception) {
            http_response_code(500);
            die ("Can't execute query '$sql': '{$exception->getMessage()}'");
        }
        break;
    case 'post':
        break;
    case 'delete':
        if (empty($id = filter_input(INPUT_GET, 'id'))) {
            http_response_code(400);
            die;
        }

        $sql = "DELETE FROM contacts WHERE id = :id";
        $st = $db->prepare($sql);
        try {
            $st->execute([
                'id' => $id,
            ]);
        } catch (Exception $exception) {
            http_response_code(500);
            die($exception->getMessage());
        }
        break;
    case 'put':
        if (empty($id = filter_input(INPUT_GET, 'id'))) {
            http_response_code(400);
            die;
        }

        parse_str(file_get_contents('php://input'), $_POST);

        if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email'])) {
            http_response_code(400);

            die;
        }
        $sql = 'UPDATE contacts SET firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id';
        $st = $db->prepare($sql);

        try {
            $st->execute([
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'id' => $id,
            ]);
            http_response_code(200);
        } catch (PDOException $exception) {
            http_response_code(500);

            die ($exception->getMessage());
        }

        break;
}