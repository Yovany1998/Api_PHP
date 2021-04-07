<?php

    header("Content-Type: application/json");

    session_start();

    $data = array(
        "server" => array(
            "dsc" => "API Server App Movil 2",
            "ver" => "0.0.1",
            "usr" => isset($_SESSION['UsrUsr'])?$_SESSION['UsrUsr']:"NO AUTH"
        )
    ); 

    echo json_encode($data);
?>