<?php
    $user        = 'root';
    $password     = '';
    $host         = 'localhost';
    $databaseName = 'cetera_reviews_db';

    $mysql_connect_link = @mysql_connect($host, $user,
        $password, $databaseName);

    if (!mysql_select_db($databaseName, $mysql_connect_link))
        die('Ошибка соединения с БД: '.$databaseName);

    @mysql_set_charset('utf8');
?>