<?php

$app->get('/contacts/index.json', function () use ($app, $db) {
    $app->response->header('Content-Type', 'application/json');
    echo json_encode(array(
        'contacts' => $db->rows("SELECT * FROM `contacts` ORDER BY `id` DESC"),
        'total' => $db->numRows("SELECT * FROM `contacts`"),
    ), JSON_PRETTY_PRINT);
});

$app->post('/contacts/store', function () use ($app, $db) {
    $app->response->header('Content-Type', 'application/json');
    $posts = $app->request->post();
    if (API_KEY == $posts['api_key']) {
        $sql = <<<SQL
INSERT INTO `contacts`
(`fullname`, `email`)
VALUES
(?, ?)
SQL;
        if ($db->execute($sql, array($posts['fullname'], $posts['email']))) {
            echo json_encode(array(
                'status' => 'pass',
                'message' => 'Contact added successfully',
            ));
        } else {
            echo json_encode(array(
                'status' => 'fail',
                'message' => 'Could not create contact. Please try again.',
            ));
        }
    } else {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Wrong api key.',
        ));
    }
});

$app->get('/contacts/store/:id', function ($id) use ($app, $db) {
    $app->response->header('Content-Type', 'application/json');
    $gets = $app->request->get();
    $id = (int) $id;
    if (API_KEY == $gets['api_key']) {
        $sql = <<<SQL
SELECT `contacts`.*
FROM `contacts`
WHERE
`contacts`.id = ?
SQL;
        $contact = $db->row($sql, array($id));
        // $app->render('http://slimapi/app/show.html', echo json_encode(array(
        //     'contact' => $contact,
        // )));
        echo json_encode(array(
            'contact' => $contact,
            'status' => 'pass',
        ));
    } else {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Wrong api key.',
        ));
    }
});

$app->put('/contacts/store/:id', function ($id) use ($app, $db) {
    $app->response->header('Content-Type', 'application/json');
    $data = $app->request->put();
    $id = (int) $id;
    if (API_KEY == $data['api_key']) {
        $sql = <<<SQL
UPDATE `contacts` SET
`contacts`.`fullname` = ?,
`contacts`.`email` = ?
WHERE
`contacts`.`id` = ?;
SQL;
        if ($db->execute($sql, array($data['fullname'], $data['email'], $id))) {
            echo json_encode(array(
                'status' => 'pass',
                'message' => 'Contact updated successfully',
            ));
        } else {
            echo json_encode(array(
                'status' => 'fail',
                'message' => 'Could not update contact. Please try again.',
            ));
        }
    } else {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Wrong api key.',
        ));
    }
});

$app->delete('/contacts/index/:id', function ($id) use ($app, $db) {
    $app->response->header('Content-Type', 'application/json');
    $deletes = $app->request->delete();
    if (API_KEY == $deletes['api_key']) {
        $contact = $db->row("SELECT * FROM `contacts` WHERE `id` = ?", array((int) $id));
        if ($contact) {
            if ($db->execute("DELETE FROM `contacts` WHERE `id` = ?", array((int) $contact->id))) {
                echo json_encode(array(
                    'status' => 'pass',
                    'message' => 'Contact ' . $contact->fullname . ' deleted successfully',
                ));
            } else {
                echo json_encode(array(
                    'status' => 'fail',
                    'message' => 'Could not delete contact. Please try again.',
                ));
            }
        } else {
            echo json_encode(array(
                'status' => 'fail',
                'message' => 'Contact not found.',
            ));
        }
    } else {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Wrong api key.',
        ));
    }
});
