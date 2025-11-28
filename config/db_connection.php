<?php

    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "sportzona";

    $connection = new mysqli($server, $user, $password, $db);

    if($connection -> connect_errno){
        die("Error de la conexión: " . $connection -> connect_errno);
    }else{
        // echo "Conexión exitosa";
    }

