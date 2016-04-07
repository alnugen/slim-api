<?php

$app->get('/migrate/contacts/up', function () use ($app, $db) {
    $sql = <<<SQL
CREATE TABLE IF NOT EXISTS `contacts`(
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`fullname` VARCHAR(40) NOT NULL,
`email` VARCHAR(255) NOT NULL,
PRIMARY KEY (`id`)
);
SQL;
    var_dump($db->execute($sql));
});

$app->get('/migrate/contacts/down', function () use ($app, $db) {
    $sql = <<<SQL
DROP TABLE IF EXISTS `contacts`;
SQL;
    var_dump($db->execute($sql));
});
