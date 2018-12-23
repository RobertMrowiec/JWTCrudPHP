<?php

    $host = "localhost";
    $db_name = "firstCrud";
    $username = "root";
    $password = "root";
    $connection;

    $connection = mysqli_connect($host, $username, $password, $db_name);

    if( !$connection ) {
        die("connection object not created: ".mysqli_error($connection));
    }

    if (mysqli_connect_error()) die("Connection Error.");
    echo "Database Connection Successfully.<br>"; 

    echo mysqli_get_host_info($connection)
?>
