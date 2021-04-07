<?php
    $hostname = $config->db->hostname;
    $username = $config->db->username;
    $password = $config->db->password;
    $database = $config->db->database;

    $mydb = mysqli_connect($hostname, $username, $password, $database);

    if(!$mydb){
        echo "Error al concetar a la base de datos";
        print_r($mydb->error);
        die();
    }
?>